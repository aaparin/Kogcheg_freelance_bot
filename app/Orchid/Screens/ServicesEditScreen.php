<?php

namespace App\Orchid\Screens;

use App\Models\ServicesModel;
use Illuminate\Http\Request;
use Orchid\Support\Facades\Alert;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;

class ServicesEditScreen extends Screen
{

    /**
     * @var ServicesModel
     */
    public $service;

    /**
     * Query data.
     *
     * @return array
     */
    public function query(ServicesModel $service): array
    {
        return [
            'service' => $service
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->service->exists ? 'Редактирование услуги' : 'Добавление услуги';
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make('Добавить')
                ->icon('pencil')
                ->method('createOrUpdate')
                ->canSee(!$this->service->exists),

            Button::make('Обновить')
                ->icon('note')
                ->method('createOrUpdate')
                ->canSee($this->service->exists),

            Button::make('Удалить')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->service->exists),
        ];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        //dd($this->service);
        return [

            Layout::rows([
                Input::make('services.name')
                    ->title('Название')
                    ->value($this->service->name)
                    ->placeholder('Название услуги'),

//                Input::make('services.parent_id')
//                    ->title('Родительский раздел'),
                Input::make('services.sort')
                    ->type('number')
                    ->value($this->service->sort ?? 500)
                    ->title('Сортировка'),
                CheckBox::make('services.user_show')
                    ->sendTrueOrFalse(true)
                    ->value($this->service->user_show ?? true)
                    ->title('Показывать пользователю')
                    ->placeholder('Да'),

                Relation::make('services.parent_id')
                    ->title('Родительский раздел')
                    ->fromModel(ServicesModel::class, 'name', '')

//                Quill::make('post.body')
//                    ->title('Main text'),

            ])
        ];
    }

    public function createOrUpdate(ServicesModel $servicesModel, Request $request)
    {
        $dataArray = $request->get('services');
        if (is_null($dataArray['parent_id'])) {
            $dataArray['parent_id'] = 0;
        }
        //dd($dataArray);
        $servicesModel->fill($dataArray)->save();

        Alert::info('Сохранено');

        return redirect()->route('platform.services');
    }

    /**
     * @param Post $post
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function remove(ServicesModel $servicesModel)
    {
        $servicesModel->delete();

        Alert::info('Удалено.');

        return redirect()->route('platform.services');
    }

}
