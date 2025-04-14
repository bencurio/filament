<?php

namespace Filament\Infolists\Components\Contracts;

use Filament\Infolists\Components\Actions\Action;
use Filament\Infolists\Components\Actions\ActionGroup;

interface HasHeaderActions
{
    /**
     * @return array<Action | ActionGroup>
     */
    public function getHeaderActions(): array;
}
