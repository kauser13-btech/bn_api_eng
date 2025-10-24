<div class="col-md-6 m-auto">
    <div class="row">
        <div class="card">
            <div class="card-header card-header-rose card-header-text">
                <div class="card-icon">
                    <i class="material-icons">lock</i>
                </div>
                <h4 class="card-title">Enable Two-Factor</h4>
            </div>
            <div class="card-body">

                @if (!auth()->user()->two_factor_secret)
                    {{-- Enable 2FA --}}
                    <form class="text-center" method="POST" action="{{ url('ewmgl/user/two-factor-authentication') }}">
                        @csrf

                        <button type="submit" class="btn btn-warning btn-lg">
                            {{ __('Enable Two-Factor') }}
                        </button>
                    </form>
                @else
                    {{-- Disable 2FA --}}
                    {{-- <form method="POST" action="{{ url('ewmgl/user/two-factor-authentication') }}">
                        @csrf
                        @method('DELETE')

                        <button type="submit">
                            {{ __('Disable Two-Factor') }}
                        </button>
                    </form> --}}

                    {{-- Show SVG QR Code, After Enabling 2FA --}}
                    <div class="text-center">
                        <h4>
                            {{ __('Two factor authentication is now enabled. Scan the following QR code using your phone\'s authenticator application.') }}
                        </h4>
                        <div class="mb-3 pb-3 border-bottom">
                            {!! auth()->user()->twoFactorQrCodeSvg() !!}
                        </div>

                        {{-- Show 2FA Recovery Codes --}}
                        <h4>
                            {{ __('Store these recovery codes in a secure password manager. They can be used to recover access to your account if your two factor authentication device is lost.') }}
                        </h4>
                        <div>
                            @foreach (json_decode(decrypt(auth()->user()->two_factor_recovery_codes), true) as $code)
                                <div class="text-danger">{{ $code }}</div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Regenerate 2FA Recovery Codes --}}
                    {{-- <form method="POST" action="{{ url('ewmgl/user/two-factor-recovery-codes') }}">
                        @csrf

                        <button type="submit">
                            {{ __('Regenerate Recovery Codes') }}
                        </button>
                    </form> --}}
                @endif

            </div>
            @if (auth()->user()->two_factor_secret)
                <div class="card-footer">
                    <button class="btn btn-success btn-lg w-100" onClick="window.location.reload();">Confirm</button>
                </div>
            @endif
        </div>
    </div>
</div>
