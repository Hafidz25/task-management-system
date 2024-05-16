<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BriefResource\Pages;
use App\Filament\Resources\BriefResource\RelationManagers;
use App\Models\Brief;
// use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;

class BriefResource extends Resource
{
    protected static ?string $model = Brief::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make()                    
                    ->schema([
                        Forms\Components\Section::make('Brief Info')
                            ->schema([
                                Forms\Components\TextInput::make('title')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\RichEditor::make('description')
                                    ->toolbarButtons([
                                        // 'attachFiles',
                                        'blockquote',
                                        'bold',
                                        'bulletList',
                                        'codeBlock',
                                        'h2',
                                        'h3',
                                        'italic',
                                        'link',
                                        'orderedList',
                                        'redo',
                                        'strike',
                                        'underline',
                                        'undo',
                                    ])
                                    ->required()
                                    ->columnSpanFull(),
                                Forms\Components\FileUpload::make('file')
                                    ->directory('briefs')
                                    ->enableDownload()
                                    ->enableOpen(),
                            ])
                            ->columnSpan([
                                'lg' => 12,
                                'xl' => 6,
                            ]),
                        Forms\Components\Section::make()
                            ->schema([
                                Forms\Components\Select::make('user_id')
                                    ->label('Assign')
                                    ->relationship(name: 'user', titleAttribute: 'name')
                                    // ->multiple()
                                    ->preload()
                                    ->searchable(),
                                Forms\Components\Select::make('status')
                                    ->options([
                                        'Customer Service' => [
                                            'assigned' => 'Assigned',
                                            'in_review' => 'In Review',
                                            'waiting' => 'Waiting',
                                            'corection' => 'Corection',
                                            'done' => 'Done',
                                        ],
                                        'Team Member' => [
                                            'in_progress' => 'In Progress',
                                            'need_review' => 'Need Review',
                                        ],
                                        
                                    ])
                                    ->native(false),
                            ])
                            ->columnSpan([
                                'lg' => 12,
                                'xl' => 3,
                            ]),
                    ])->columns(9),
                
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('file')
                    ->searchable(),
                    // ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Assign')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'assigned' => 'gray',
                        'in_review' => 'warning',
                        'waiting' => 'warning',
                        'in_progress' => 'warning',
                        'need_review' => 'warning',
                        'corection' => 'danger',
                        'done' => 'success',
                    })
                    ->icon(fn (string $state): string => match ($state) {
                        'assigned' => 'heroicon-m-pencil-square',
                        'in_review' => 'heroicon-m-eye',
                        'waiting' => 'heroicon-m-arrow-path',
                        'in_progress' => 'heroicon-m-clock',
                        'need_review' => 'heroicon-m-chat-bubble-bottom-center-text',
                        'corection' => 'heroicon-m-bug-ant',
                        'done' => 'heroicon-m-check-circle',
                    })
                    ->formatStateUsing(fn ($state): string => Str::headline($state))
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBriefs::route('/'),
            'create' => Pages\CreateBrief::route('/create'),
            'edit' => Pages\EditBrief::route('/{record}/edit'),
        ];
    }
}
