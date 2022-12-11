<?php

namespace wsydney76\contentoverview\models\filters;

use craft\elements\User;
use Illuminate\Support\Collection;

class UsersFieldFilter extends BaseRelationFieldFilter
{
    public string $filterType = 'usersField';
    public array|string|null $userGroups = null;

    /**
     * @return Collection
     */
    public function getOptions(): Collection
    {

        $this->options = User::find()
            ->orderBy($this->orderBy)
            ->group($this->userGroups)
            ->collect()
            ->map(fn($user) => [
                'label' => $user->name,
                'value' => $user->id
            ]);

        return parent::getOptions();
    }
    
    public function userGroups(array|string $userGroups): self
    {
        $this->userGroups = $userGroups;
        return $this;
    }


}