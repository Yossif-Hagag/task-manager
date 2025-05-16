@extends('adminlte::page')
@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content_header')
    <h1><i class="fas fa-user-edit"></i> Edit Profile</h1>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- Success Message -->
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <!-- Error Messages -->
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle"></i> There were some errors with your input:
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <div class="row d-flex justify-content-between align-items-center">
                <div class="card card-primary p-0 col-md-8">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-user-circle"></i> Update Profile</h3>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')

                            <!-- User Avatar -->
                            <div class="text-center mb-3">
                                <img src="{{ asset(Auth::user()->avatar ?? 'default-avatar.png') }}"
                                    class="img-circle elevation-2" width="100" height="100" alt="User Avatar">
                                <div class="mt-2">
                                    <input type="file" name="avatar" class="form-control-file">
                                </div>
                            </div>

                            <div class="form-group">
                                <label><i class="fas fa-user"></i> Name</label>
                                <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}"
                                    class="form-control @error('name') is-invalid @enderror" required>
                                @error('name')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label><i class="fas fa-envelope"></i> Email</label>
                                <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}"
                                    class="form-control @error('email') is-invalid @enderror" required>
                                @error('email')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Password Update -->
                            <div class="form-group">
                                <label><i class="fas fa-lock"></i> New Password</label>
                                <input type="password" name="password"
                                    class="form-control @error('password') is-invalid @enderror">
                                @error('password')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label><i class="fas fa-lock"></i> Confirm Password</label>
                                <input type="password" name="password_confirmation" class="form-control">
                            </div>

                            <button type="submit" class="btn btn-primary btn-block">
                                <i class="fas fa-save"></i> Update Profile
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Delete Account Section -->
                <div class="card card-danger p-0 col-md-3">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-trash"></i> Delete Account</h3>
                    </div>
                    <div class="card-body">
                        <button type="button" class="btn btn-danger btn-block" data-toggle="modal"
                            data-target="#deleteModal">
                            <i class="fas fa-trash-alt"></i> Delete
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title"><i class="fas fa-exclamation-triangle"></i> Confirm Deletion</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete your account? This action cannot be undone!</p>
                    <form method="POST" action="{{ route('profile.destroy') }}">
                        @csrf
                        @method('DELETE')

                        @if (!empty(Auth::user()->password) && empty(Auth::user()->provider))
                            <div class="form-group">
                                <label><i class="fas fa-lock"></i> Confirm Password</label>
                                <input type="password" name="passwordConfirm"
                                    class="form-control @error('passwordConfirm') is-invalid @enderror" required>
                                @error('passwordConfirm')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        @endif

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash"></i> Delete Account
                            </button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                <i class="fas fa-times"></i> Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection