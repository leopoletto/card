<?php

namespace App\StateMachines\CardSwitcherTask;

interface CardSwitcherTaskStateContract
{
    public function finalize();

    public function fail();

    public function pending();
}
