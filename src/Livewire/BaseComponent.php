<?php

namespace TenantForge\Livewire;

use Illuminate\Support\MessageBag;
use Illuminate\Support\ViewErrorBag;
use Livewire\Component;

/**
 * Base component that fixes Livewire DataStore WeakMap issues in testing environments.
 *
 * ISSUE: Livewire's DataStore uses WeakMap which can fail in testing/package environments.
 * When store($this)->get('errorBag') returns null even after setErrorBag() was called,
 * it causes "Argument #2 ($bag) must be of type MessageBag, null given" errors.
 *
 * SOLUTION: Override getErrorBag() to bypass the broken DataStore and handle
 * error bag initialization directly.
 *
 * All TenantForge Livewire components should extend this class.
 */
abstract class BaseComponent extends Component
{
    /**
     * Override getErrorBag to work around DataStore WeakMap issues.
     *
     * This bypasses store($this)->get('errorBag') which returns null when
     * the WeakMap doesn't maintain object references correctly in testing.
     */
    public function getErrorBag()
    {
        // Try to get from parent (DataStore) first
        $errorBag = parent::getErrorBag();

        // If DataStore failed (returned null), initialize manually
        if (! $errorBag instanceof MessageBag) {
            // Replicate the logic from HandlesValidation::getErrorBag()
            $previouslySharedErrors = app('view')->getShared()['errors'] ?? new ViewErrorBag;
            $errorBag = new MessageBag($previouslySharedErrors->getMessages());

            // Try to store it back (may fail in testing, but that's OK)
            $this->setErrorBag($errorBag);
        }

        return $errorBag;
    }
}
