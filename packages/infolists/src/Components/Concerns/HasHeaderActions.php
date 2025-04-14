<?php

namespace Filament\Infolists\Components\Concerns;

use Closure;
use Filament\Infolists\Components\Actions\Action;
use Filament\Infolists\Components\Actions\ActionGroup;
use Illuminate\Support\Arr;

trait HasHeaderActions
{
    /**
     * @var array<Action | ActionGroup> | null
     */
    protected ?array $cachedHeaderActions = null;

    /**
     * @var array<Action | ActionGroup | Closure>
     */
    protected array $headerActions = [];

    /**
     * @param  array<Action | ActionGroup | Closure>  $actions
     */
    public function headerActions(array $actions): static
    {
        $this->headerActions = [
            ...$this->headerActions,
            ...$actions,
        ];

        return $this;
    }

    /**
     * @return array<Action | ActionGroup>
     */
    public function getHeaderActions(): array
    {
        return $this->cachedHeaderActions ?? $this->cacheHeaderActions();
    }

    /**
     * @return array<Action | ActionGroup>
     */
    public function cacheHeaderActions(): array
    {
        $this->cachedHeaderActions = [];

        foreach ($this->headerActions as $headerAction) {
            foreach (Arr::wrap($this->evaluate($headerAction)) as $action) {
                if ($action instanceof Action) {
                    $this->cachedHeaderActions[$action->getName()] = $this->prepareAction($action);
                }

                if ($action instanceof ActionGroup) {
                    $this->cachedHeaderActions[] = $this->prepareAction($action);

                    foreach ($action->getFlatActions() as $action) {
                        $this->prepareAction($action);
                    }
                }
            }
        }

        return $this->cachedHeaderActions;
    }
}
