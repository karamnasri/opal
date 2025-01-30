<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReadNotificationRequest;
use App\Http\Resources\NotificationCollection;
use App\Services\NotificationService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    use ApiResponseTrait;
    public function __construct(public NotificationService $notificationService) {}
    public function index()
    {
        $data = $this->notificationService->getMyNotification();
        return $this->successResponse(new NotificationCollection($data), 'notification returned successfully');
    }

    public function read(ReadNotificationRequest $request)
    {
        $this->notificationService->markAsRead($request->notifications);
        return $this->successResponse([], 'Notifications marked as read');
    }
}
