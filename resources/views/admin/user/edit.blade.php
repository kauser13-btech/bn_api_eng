@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <form class="form-horizontal" action="{{ route('user.update', $User->id) }}" method="POST">
                @csrf
                @method('PATCH')
                @if (Session::has('success'))
                    <script type="text/javascript">
                        setTimeout(function() {
                            md.showNotification('top', 'center', 'success', "{{ Session::get('success') }}").trigger('click');
                        }, 100);
                    </script>
                @endif
                <div class="card ">
                    <div class="card-header card-header-rose card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">perm_identity</i>
                        </div>
                        <h4 class="card-title">Edit Form</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <label class="col-sm-2 col-form-label">Name</label>
                            <div class="col-sm-7">
                                <div class="form-group">
                                    <input class="form-control" type="text" name="name" required="true"
                                        value="{{ $User->name }}" />
                                </div>
                            </div>
                            <label class="col-sm-3 label-on-right"><code>required</code></label>
                        </div>
                        <div class="row">
                            <label class="col-sm-2 col-form-label">Email Address</label>
                            <div class="col-sm-7">
                                <div class="form-group">
                                    <input type="email" name="email" class="form-control" id="exampleEmail"
                                        required="true" value="{{ $User->email }}">
                                </div>
                            </div>
                            <label class="col-sm-3 label-on-right"><code>required</code></label>
                        </div>
                        <div class="row">
                            <label class="col-sm-2 col-form-label">New Password</label>
                            <div class="col-sm-7">
                                <div class="form-group">
                                    <input type="password" class="form-control" id="examplePassword" name="password">
                                    <input type="hidden" name="old-password" value="{{ $User->password }}">
                                </div>
                            </div>
                            <label class="col-sm-3 label-on-right"><code>required</code></label>
                        </div>
                        <div class="row">
                            <label class="col-sm-2 col-form-label">Designation</label>
                            <div class="col-sm-7">
                                <div class="form-group">
                                    <input class="form-control" type="text" name="designation" required="true"
                                        value="{{ $User->designation }}" />
                                </div>
                            </div>
                            <label class="col-sm-3 label-on-right"><code>required</code></label>
                        </div>
                        <div class="row">
                            <label class="col-sm-2 col-form-label">Role</label>
                            <div class="col-sm-7">
                                <div class="form-group">
                                    <select class="selectpicker" data-size="7" data-style="select-with-transition"
                                        title="User Role" name="role">
                                        <option @if ($User->role == 'developer') selected @endif value="developer">
                                            Developer</option>
                                        <option @if ($User->role == 'editor') selected @endif value="editor">Editor
                                        </option>
                                        <option @if ($User->role == 'contributor') selected @endif value="contributor">
                                            Contributor</option>
                                        <option @if ($User->role == 'subscriber') selected @endif value="subscriber">
                                            Subscriber</option>
                                    </select>
                                </div>
                            </div>
                            <label class="col-sm-3 label-on-right"><code>required</code></label>
                        </div>
                        <div class="row">
                            <label class="col-sm-2 col-form-label">Type</label>
                            <div class="col-sm-7">
                                <div class="form-group">
                                    <select class="selectpicker" data-size="7" data-style="select-with-transition"
                                        title="User Type" name="type">
                                        <option @if ($User->type == 'all') selected @endif value="all">All
                                        </option>
                                        <option @if ($User->type == 'online') selected @endif value="online">Online
                                        </option>
                                        <option @if ($User->type == 'print') selected @endif value="print">Print
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <label class="col-sm-3 label-on-right"><code>required</code></label>
                        </div>
                        <div class="row my-3">
                            <label class="col-sm-2 col-form-label pt-0">Reset 2FA</label>
                            <div class="col-sm-7">
                                <div class="togglebutton">
                                    <label>
                                        <input name="2fa" type="checkbox" value="1">
                                        <span class="toggle"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-sm-2 col-form-label">Status</label>
                            <div class="col-sm-7">
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="radio" name="status" value="1"
                                            @if ($User->status == 1) checked @endif> Active
                                        <span class="circle"><span class="check"></span></span>
                                    </label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="radio" name="status" value="0"
                                            @if ($User->status == 0) checked @endif> Inactive
                                        <span class="circle"><span class="check"></span></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-rose">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('breadcrumbs')
    Update User
@endpush

@push('meta')
    <title>Update User Info</title>
@endpush

@push('stylesheet')
@endpush

@push('scripts')
@endpush
