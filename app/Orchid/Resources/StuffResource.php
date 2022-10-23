<?php

namespace App\Orchid\Resources;

use App\Models\Places;
use App\Models\Stuff;
use Orchid\Crud\Resource;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\TD;

class StuffResource extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = Stuff::class;

    public static function label(): string
    {
        return 'Работники';
    }

    public static function createButtonLabel(): string
    {
        return 'Добавить';
    }

    public static function icon(): string
    {
        return 'android';
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
                ->title('Имя')
                ->required(),
            Select::make('status')
                ->options(Stuff::getStatuses())
                ->title('Статус'),
            TextArea::make('description')
                ->title('Расскажите о себе')
                ->rows(5)
                ->required(),
            Input::make('contacts')
                ->title('Контантная информация')
                ->required(),
            Input::make('safe_for_uk')
                ->title('Скидки для граждан Украины'),
            CheckBox::make('online')
                ->sendTrueOrFalse(true)
                ->title('Вы оказываете услуги online?')
                ->placeholder('Да'),
            Relation::make('offline_place')
                ->title('Местоположение для Offline')
                ->fromModel(Places::class, 'name')
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
            TD::make('id'),

            TD::make('name'),
            TD::make('status'),
            TD::make('online'),

            TD::make('created_at', 'Date of creation')
                ->render(function ($model) {
                    return $model->created_at->toDateTimeString();
                }),

            TD::make('updated_at', 'Update date')
                ->render(function ($model) {
                    return $model->updated_at->toDateTimeString();
                }),
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
