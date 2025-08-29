<?php

declare(strict_types=1);

namespace TenantForge\Filament\Actions;

use Exception;
use Filament\Actions\Action;
use Illuminate\Http\RedirectResponse;
use Livewire\Features\SupportRedirects\Redirector;
use TenantForge\Actions\Content\CreateContentTranslationAction;
use TenantForge\Contracts\Translatable;
use TenantForge\Filament\Central\Resources\Posts\Pages\EditPost;
use TenantForge\Models\Language;
use TenantForge\Models\Post;
use Throwable;

use function redirect;

class LanguageSelector extends Action
{
    private ?Translatable $translatableRecord = null;

    private Translatable $originalTranslatableRecord;

    public function setUp(): void
    {
        parent::setUp();

        if ($this->translatableRecord instanceof Post) {
            $this->view('tenantforge::filament.actions.language-selector', [
                'post' => $this->translatableRecord,
                'name' => $this->name,
            ]);
        }

        $this->action(function (array $arguments = []): void {
            if (isset($arguments['languageId'])) {
                /** @var ?Language $language */
                $language = Language::query()
                    ->where('id', $arguments['languageId'])
                    ->first();
                if ($language) {
                    $this->createTranslation($language);
                }
            }
        });
    }

    /**
     * @return $this
     */
    public function setView(Translatable $record): static
    {

        $this->view('tenantforge::filament.actions.language-selector', [
            'post' => $this->translatableRecord = $record,
            'originalPost' => $this->originalTranslatableRecord = $record->isTranslation() ? $record->getOriginalTranslation() : $record,
            'translations' => $this->translatableRecord->getTranslations(),
            'missingTranslations' => $this->translatableRecord->getMissingTranslations(),
            'name' => $this->name,
        ]);

        return $this;
    }

    /**
     * @throws Exception
     * @throws Throwable
     */
    public function createTranslation(Language $language): Redirector|RedirectResponse
    {
        /** @var Post $post */
        $post = app(CreateContentTranslationAction::class)
            ->handle($this->originalTranslatableRecord, $language);

        return redirect()->intended(EditPost::getUrl([
            'record' => $post->id,
            'type' => $post->type->slug,
        ]));

    }
}
