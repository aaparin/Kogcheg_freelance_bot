<?php

namespace App\Orchid\Resources;

use App\Models\Nav;
use App\Models\Services;
use Orchid\Crud\Resource;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\TD;

class NavResource extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = Nav::class;


    public static function label(): string
    {
        return 'Навигация';
    }

    public static function createButtonLabel(): string
    {
        return 'Добавить';
    }

    public static function icon(): string
    {
        return 'menu';
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @return array
     */
    public function fields(): array
    {
        return [

            Input::make('name')
                ->title('Название')
                ->placeholder('Название'),
            TextArea::make('description')
                ->title('Текст для пользователя'),
            Input::make('command')
                ->title('Команда'),
            CheckBox::make('active')
                ->sendTrueOrFalse(true)
                ->checked()
                ->title('Показывать пользователю')
                ->placeholder('Да'),
            Relation::make('parent_id')
                ->title('Родительский раздел')
                ->fromModel(Nav::class, 'name')


        ];
    }

    /**
     * Get the columns displayed by the resource.
     *
     * @return TD[]
     */
    public function columns(): array
    {
        return [
            TD::make('id', 'ID'),
            TD::make('name', 'Название'),
            TD::make('command', 'Команда'),
            TD::make('parent_id', 'Родитель')
                ->filter(
                    Relation::make('parent_id')
                        ->title('Родительский раздел')
                        ->fromModel(Nav::class, 'name')
                )
                ->render(function ($service) {
                    return $service->getName($service->parent_id);
                }),

//            TD::make('created_at', 'Date of creation')
//                ->render(function ($model) {
//                    return $model->created_at->toDateTimeString();
//                }),
//
//            TD::make('updated_at', 'Update date')
//                ->render(function ($model) {
//                    return $model->updated_at->toDateTimeString();
//                }),
        ];
    }

    /**
     * Get the sights displayed by the resource.
     *
     * @return Sight[]
     */
    public function legend(): array
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @return array
     */
    public function filters(): array
    {
        return [];
    }
}
