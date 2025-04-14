<?php

namespace Filament\Infolists\Components\Contracts;

use Filament\Infolists\Components\Actions\Action;
use Filament\Infolists\Components\Actions\ActionGroup;

interface HasFooterActions
{
    /**
     * @return array<Action | ActionGroup>
     */
    public function getFooterActions(): array;
}
