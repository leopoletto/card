<?php
namespace App\Enums;

enum CardSwitcherTaskStatusEnum: string
{
    case Pending = 'pending';
    case Finished = 'finished';
    case Failed = 'failed';
}
