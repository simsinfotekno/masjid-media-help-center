<?php

namespace Modules\MasjidMediaHelpCenter\Http\Controllers;

use App\Conversation;
use App\Customer;
use App\Http\Controllers\Controller;
use App\Mailbox;
use App\Thread;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    const MIN_SECONDS_TO_FILL = 3;
    const MAX_SECONDS_TO_FILL = 7200;

    public function __construct()
    {
        $this->middleware('mm.public_locale');
    }

    public function show(Request $request)
    {
        return view('masjidmediahelpcenter::contact', [
            'topics' => $this->topics(),
            'startedAt' => Crypt::encryptString((string) time()),
        ]);
    }

    public function submit(Request $request)
    {
        // Silently accept bot submissions without creating anything, so
        // the bot gets no signal that it was caught.
        if (!$this->passesBotChecks($request)) {
            return redirect()
                ->route('masjidmediahelpcenter.contact.show')
                ->with('mm_contact_success', true);
        }

        $topics = $this->topics();

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:191',
            'topic' => 'required|string|in:'.implode(',', array_keys($topics)),
            'subject' => 'required|string|max:150',
            'message' => 'required|string|min:10|max:5000',
        ], [
            'name.required' => __('masjidmediahelpcenter::site.contact.error_name_required'),
            'email.required' => __('masjidmediahelpcenter::site.contact.error_email_required'),
            'email.email' => __('masjidmediahelpcenter::site.contact.error_email_invalid'),
            'topic.required' => __('masjidmediahelpcenter::site.contact.error_topic_required'),
            'subject.required' => __('masjidmediahelpcenter::site.contact.error_subject_required'),
            'message.required' => __('masjidmediahelpcenter::site.contact.error_message_required'),
            'message.min' => __('masjidmediahelpcenter::site.contact.error_message_short'),
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('masjidmediahelpcenter.contact.show')
                ->withErrors($validator)
                ->withInput();
        }

        // validated() was only added in Laravel 5.7; this app runs 5.5.
        $data = $request->only(['name', 'email', 'topic', 'subject', 'message']);

        $mailbox = Mailbox::find(config('masjidmediahelpcenter.mailbox_id'));

        if (!$mailbox) {
            Log::error('MasjidMediaHelpCenter: HELPCENTER_MAILBOX_ID is not set or does not match a mailbox.');

            return redirect()
                ->route('masjidmediahelpcenter.contact.show')
                ->withInput()
                ->with('mm_contact_fallback', config('masjidmediahelpcenter.support_email'));
        }

        $customer = Customer::create($data['email'], [
            'first_name' => $data['name'],
        ]);

        if (!$customer) {
            return redirect()
                ->route('masjidmediahelpcenter.contact.show')
                ->withErrors(['email' => __('masjidmediahelpcenter::site.contact.error_email_invalid')])
                ->withInput();
        }

        // Escape before storing: the thread body is rendered unpurified
        // in several places (conversation list preview, notification
        // emails), so plain text must already be safe HTML on the way in.
        $body = nl2br(htmlspecialchars($data['message'], ENT_QUOTES, 'UTF-8'));
        // Always tag the subject in Indonesian, regardless of the
        // customer's chosen form language, so agent triage stays
        // consistent across submissions.
        $subject = '['.$this->topicLabelForTriage($data['topic']).'] '.$data['subject'];

        $result = Conversation::create([
            'type' => Conversation::TYPE_EMAIL,
            'subject' => $subject,
            'mailbox_id' => $mailbox->id,
            'source_type' => Conversation::SOURCE_TYPE_WEB,
            'source_via' => Conversation::PERSON_CUSTOMER,
        ], [[
            'type' => Thread::TYPE_CUSTOMER,
            'body' => $body,
        ]], $customer);

        if (!$result) {
            Log::error('MasjidMediaHelpCenter: Conversation::create failed for contact form submission.');

            return redirect()
                ->route('masjidmediahelpcenter.contact.show')
                ->withInput()
                ->with('mm_contact_fallback', config('masjidmediahelpcenter.support_email'));
        }

        // createExtended() hard-codes SOURCE_TYPE_API; correct it to WEB
        // now that the thread exists.
        $result['thread']->source_type = Thread::SOURCE_TYPE_WEB;
        $result['thread']->save();

        return redirect()
            ->route('masjidmediahelpcenter.contact.show')
            ->with('mm_contact_success', true);
    }

    protected function topics(): array
    {
        return [
            'mobile_app' => __('masjidmediahelpcenter::site.contact.topic_mobile_app'),
            'tv_app' => __('masjidmediahelpcenter::site.contact.topic_tv_app'),
            'account' => __('masjidmediahelpcenter::site.contact.topic_account'),
            'other' => __('masjidmediahelpcenter::site.contact.topic_other'),
        ];
    }

    protected function topicLabelForTriage(string $topicKey): string
    {
        $labels = [
            'mobile_app' => __('masjidmediahelpcenter::site.contact.topic_mobile_app', [], 'id'),
            'tv_app' => __('masjidmediahelpcenter::site.contact.topic_tv_app', [], 'id'),
            'account' => __('masjidmediahelpcenter::site.contact.topic_account', [], 'id'),
            'other' => __('masjidmediahelpcenter::site.contact.topic_other', [], 'id'),
        ];

        return $labels[$topicKey] ?? $topicKey;
    }

    protected function passesBotChecks(Request $request): bool
    {
        if ($request->filled('website')) {
            return false;
        }

        $startedAt = $request->input('started_at');

        if (!$startedAt) {
            return false;
        }

        try {
            $submittedTimestamp = (int) Crypt::decryptString($startedAt);
        } catch (\Exception $e) {
            return false;
        }

        $elapsed = time() - $submittedTimestamp;

        return $elapsed >= self::MIN_SECONDS_TO_FILL && $elapsed <= self::MAX_SECONDS_TO_FILL;
    }
}
