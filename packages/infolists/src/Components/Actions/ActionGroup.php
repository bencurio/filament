<?php

namespace Filament\Infolists\Components\Actions;

use Filament\Actions\ActionGroup as BaseActionGroup;

/**
 * @method array<Action> getFlatActions()
 * @method static actions(Array<Action | ActionGroup> $actions)
 * @method array<Action | ActionGroup> getActions()
 * @method array<Action> getFlatActions()
 *
 * @property array<Action | ActionGroup> $actions
 * @property array<Action> $flatActions
 */
class ActionGroup extends BaseActionGroup
{
    use Concerns\BelongsToInfolist;

    public function toInfolistComponent(): ActionContainer
    {
        return ActionContainer::make($this);
    }
}