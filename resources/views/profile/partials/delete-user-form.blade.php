<section class="space-y-6">
	<header>
		<h2>
			{{ __('Delete Account') }}
		</h2>

		<p>
			{{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
		</p>
	</header>

	<x-danger-button
		class="btn btn-sm btn-danger m-3"
		x-data=""
		x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
	>{{ __('Delete Account') }}</x-danger-button>

	<x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
		<form method="post" action="{{ route('profile.destroy') }}" class="p-6">
			@csrf
			@method('delete')

			<h2 class="text-lg font-medium text-gray-900">
				{{ __('Are you sure you want to delete your account?') }}
			</h2>

			<p class="mt-1 text-sm text-gray-600">
				{{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
			</p>

			<div class="mt-6">
				<div class="form-group row m-2 @error('password') has-error @enderror">
					<label for="password" class="col-sm-4 col-form-label col-form-label-sm">Password : </label>
					<div class="col-sm-8">
						<input type="password" name="password" id="password" value="{{ old('password') }}" class="form-control form-control-sm @error('username') is-invalid @enderror" placeholder="Password">
						@error('password') <div class="invalid-feedback fw-lighter">{{ $message }}</div> @enderror
					</div>
				</div>
			</div>

			<div class="mt-6 flex justify-end">
				<x-secondary-button x-on:click="$dispatch('close')"  class="btn btn-sm btn-outline-secondary">
					{{ __('Cancel') }}
				</x-secondary-button>

				<x-danger-button class="btn btn-sm btn-danger m-3">
					{{ __('Delete Account') }}
				</x-danger-button>
			</div>
		</form>
	</x-modal>
</section>
