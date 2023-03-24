<?php

namespace App\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('todoitem')]
class TodoItemComponent
{
    public string $title;
    public string $description;
    public int $id;
    public int $status;
    public int $creation_ts;
    public int $start_ts;
    public int $completed_ts;
}