<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FiyatlandirmaResource\Pages;
use App\Models\Fiyatlandirma;
use App\Models\Emlakfiyatlari;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Model;
use Spatie\TranslationLoader\LanguageLine;

class FiyatlandirmaResource extends Resource
{
	protected static ?string $model = Fiyatlandirma::class;

	protected static ?string $navigationIcon = 'heroicon-o-cash';
  protected static ?int $navigationSort = 99;
	protected static function getNavigationGroup(): string
	{
		return __('menu.ayarlar');
	}

	protected static function getNavigationLabel(): string
	{
		return __('menu.fiyatlandirma');
	}

	public static function form(Form $form): Form
	{
		$schema = [];
		$diller = \App\Models\Diller::all();
    $schema[] = Forms\Components\TextInput::make('sembol')
				->label(__('form.sembol'))
				->required()
				->maxLength(255);
		foreach ($diller as $dil) {
			$schema[] = Forms\Components\TextInput::make('semboladlari.'.$dil->dilkodu)
				->label(__('form.dovizadi').' - '.$dil->diladi)
				->required()
				->maxLength(255);
		}

		return $form
			->schema(array_merge($schema, [
				Forms\Components\Toggle::make('durum')
					->label(__('form.durum'))
					->required(),
			]));
	}

	public static function table(Table $table): Table
	{
		return $table
			->columns([
				Tables\Columns\TextColumn::make('sembol'),
				Tables\Columns\IconColumn::make('durum')
					->boolean(),
				// Tables\Columns\TextColumn::make('created_at')
				//     ->dateTime(),
				// Tables\Columns\TextColumn::make('updated_at')
				//     ->dateTime(),
			])
			->filters([
				//
			])
			->actions([
				Tables\Actions\EditAction::make()
					->mutateRecordDataUsing(function (array $data): array {
						$data['semboladlari'] = LanguageLine::where('group', 'fiyatlandirma')
							->where('key', $data['id'])
							->first()
						  ?->text;

						return $data;
					})
					->using(function (Model $record, array $data): Model {
            $eskisembol = $record->sembol;
						$record->update($data);
            Emlakfiyatlari::where('sembol',$eskisembol)->update([
              'sembol' => $data['sembol']
            ]);
						LanguageLine::where('group', 'fiyatlandirma')
							->where('key', $record->id)
							->update([
								'text' => $data['semboladlari'],
							]);

						return $record;
					}),
				Tables\Actions\DeleteAction::make()
					->after(function (Model $record) {
						LanguageLine::where('group', 'fiyatlandirma')
							->where('key', $record->id)
							->delete();
					}),
			])
			->bulkActions([
				// Tables\Actions\DeleteBulkAction::make(),
			]);
	}

	public static function getPages(): array
	{
		return [
			'index' => Pages\ManageFiyatlandirmas::route('/'),
		];
	}
}
