<?php
namespace App\Jobs;

use App\Models\Order;
use App\Mail\OrderReceipt;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendOrderReceiptJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public Order $order)
    {
    }

    public function handle(): void
    {
        // 1. Find the email of the student who placed the order
        $studentEmail = $this->order->user->email;

        // 2. Send the email!
        Mail::to($studentEmail)->send(new OrderReceipt($this->order));
    }
}