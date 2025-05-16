<?php

namespace App\Services;

use Google\Client;
use Google\Service\Calendar;
use Google\Service\Calendar\Event;
use Google\Service\Calendar\EventDateTime;
use Illuminate\Support\Facades\Log;

class GoogleCalendarService
{
    // Run command has install google libary
    // composer require google/apiclient
    // Init calendar
    private $calendar;

    /**
     * Construct method init setting Google client.
     * The account that creates the event will have to share it with the service account with the "Make changes to events" permission.
     *
     * Auth config file from storage path.
     * Scope CALENDAR_EVENTS for all permision.
     */
    public function __construct()
    {
        // Init Google client
        $client = new Client();
        $client->setAuthConfig(storage_path('google_credenticals.json'));
        // dd(storage_path('google_credenticals.json'));
        $client->addScope(Calendar::CALENDAR_EVENTS);
        $this->calendar = new Calendar($client);
    }

    /**
     * Service method get a list of events from Google Calendar by CalendarID.
     * Only get new events starting 1 day ago.
     *
     * @param string $calendarId ID of the calendar to get the calendar.
     * @return null|JSON event from Google Service.
     */
    public function getEvents()
    {
        try {
            $events = $this->calendar->events->listEvents(config('services.google.calendar_id'), [
                'timeMin' => date('c', strtotime('-1 day')),
                'orderBy' => 'startTime',
                'singleEvents' => true,
            ]);
            if (!$events) {
                return null;
            }
            return $events;
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
    }

    /**
     * Service method create new event.
     *
     * @param string $summary this title of event.
     * @param string $description of event.
     * @param timestamp $startTime event start time.
     * @param timestamp $endTime event end time.
     * @param array $attendeesEmails Participant email list.
     * @return false|string event link.
     */
    public function createEvent($summary, $description, $startTime, $endTime, $attendeesEmails = [], $calendarId)
    {
        try {
            $startTime = (new \DateTime("$startTime"))->format(\DateTime::RFC3339);
            $endTime = (new \DateTime("$endTime"))->format(\DateTime::RFC3339);
            // Init new event.
            $event = new Event([
                'summary' => $summary,
                'description' => $description,
                'start' => new EventDateTime([
                    'dateTime' => $startTime,
                    'timeZone' => config('app.timezone'),
                ]),
                'end' => new EventDateTime([
                    'dateTime' => $endTime,
                    'timeZone' => config('app.timezone'),
                ]),
                'attendees' => array_map(fn ($email) => ['email' => $email], $attendeesEmails),
            ]);
            // Create an event on Google Calendar.
            // $event = $this->calendar->events->insert(config('services.google.calendar_id'), $event);
            $event = $this->calendar->events->insert($calendarId, $event);

            // Return this event link.
            return $event->htmlLink;
        } catch (\Exception $e) {
            Log::error($e->getMessage());
             dd($e);
            return false;
           
        }
    }

    /**
     * Service method update event information on Google calendar via event id.
     *
     * @param string $eventId id of event in Google calendar.
     * @param string $summary this title of event.
     * @param string $description of event.
     * @param timestamp $startTime event start time.
     * @param timestamp $endTime event end time.
     * @param array $attendeesEmails Participant email list.
     * @return false|string link of event.
     */
    public function updateEvent($eventId, $summary, $description, $startTime, $endTime, $attendeesEmails = [])
    {
        try {
            // Get existing events from Google Calendar.
            $event = $this->calendar->events->get(config('services.google.calendar_id'), $eventId);
            // Update event information.
            $event->setSummary($summary);
            $event->setDescription($description);
            $event->setStart(new \Google\Service\Calendar\EventDateTime([
                'dateTime' => $startTime,
                'timeZone' => config('app.timezone')
            ]));
            $event->setEnd(new \Google\Service\Calendar\EventDateTime([
                'dateTime' => $endTime,
                'timeZone' => config('app.timezone')
            ]));
            // Update the participant list if there are changes.
            $event->setAttendees(array_map(fn ($email) => ['email' => $email], $attendeesEmails));
            // Update events on Google Calendar.
            $updatedEvent = $this->calendar->events->update(config('services.google.calendar_id'), $eventId, $event);
            // Returns the updated event link.
            return $updatedEvent->htmlLink;
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
    }

    /**
     * Service method delete a event
     *
     * @param string $eventId id of event in Google calendar.
     * @return boolean
     */
    public function deleteEvent($eventId)
    {
        try {
            $this->calendar->events->delete(config('services.google.calendar_id'), $eventId);
            return true;
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
    }
}
