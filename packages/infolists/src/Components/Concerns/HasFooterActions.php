<?php

namespace Filament\Infolists\Components\Concerns;

use Closure;
use Filament\Infolists\Components\Actions\Action;
use Filament\Infolists\Components\Actions\ActionGroup;
use Filament\Support\Concerns\HasFooterActionsAlignment;
use Illuminate\Support\Arr;

trait HasFooterActions
{
    use HasFooterActionsAlignment;

    /**
     * @var array<Action | ActionGroup> | null
     */
    protected ?array $cachedFooterActions = null;

    /**
     * @var array<Action | ActionGroup | Closure>
     */
    protected array $footerActions = [];

    /**
     * @param  array<Action | ActionGroup | Closure>  $actions
     */
    public function footerActions(array $actions): static
    {
        $this->footerActions = [
            ...$this->footerActions,
            ...$actions,
        ];

        return $this;
    }

    /**
     * @return array<Action | ActionGroup>
     */
    public function getFooterActions(): array
    {
        return $this->cachedFooterActions ?? $this->cacheFooterActions();
    }

    /**
     * @return array<Action | ActionGroup>
     */
    public function cacheFooterActions(): array
    {
        $this->cachedFooterActions = [];

        foreach ($this->footerActions as $footerAction) {
            foreach (Arr::wrap($this->evaluate($footerAction)) as $action) {
                if ($action instanceof Action) {
                    $this->cachedFooterActions[$action->getName()] = $this->prepareAction($action);
                }

                if ($action instanceof ActionGroup) {
                    $this->cachedFooterActions[] = $this->prepareAction($action);

                    foreach ($action->getFlatActions() as $action) {
                        $this->prepareAction($action);
                    }
                }
            }
        }

        return $this->cachedFooterActions;
    }
}
