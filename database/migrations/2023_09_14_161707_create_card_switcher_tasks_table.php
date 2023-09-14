<?php

use App\Enums\CardSwitcherTaskStatusEnum;
use App\Models\Card;
use App\Models\Merchant;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('card_switcher_tasks', function (Blueprint $table) {
            $table->id();

            $table->enum('status', [
                CardSwitcherTaskStatusEnum::Pending->value,
                CardSwitcherTaskStatusEnum::Finished->value,
                CardSwitcherTaskStatusEnum::Failed->value
            ])->default(CardSwitcherTaskStatusEnum::Pending->value);

            $table->foreignIdFor(Merchant::class);
            $table->foreignIdFor(Card::class);

            $table->foreignIdFor(Card::class, 'previous_card_id')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('card_switcher_tasks');
    }
};
