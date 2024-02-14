@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row flex-wrap">
            <div class="col-md-2">
                @include('layouts.inc.user-side-menu')
            </div>
            <div class="col-md-10">
                <div class="row align-items-center py-3">
                    <div class="col-md-4">
                        <h1>Profiel</h1>
                    </div>
                    <div class="col-md-4">

                    </div>
                    <div class="col-md-4">
                        <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
  Profiel bewerken
</button>
                    </div>
                </div>
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title" id="staticBackdropLabel">Profile bewerken</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="{{ route('profile.updateProfile',$user) }}" method="post" enctype="multipart/form-data">
               @csrf
               @method('PUT')

               <div class="mb-3">
                <label for="">Naam</label>
                <input type="text" name="name" id="" class="form-control" value="{{ $user->name }}" @error('name') is-invalid @enderror>
                   @error('name')
                     <span class="invalid-feedback" role="alert">
                       <strong>{{ $message }}</strong>
                     </span>
                  @enderror
               </div>
               <div class="mb-3">
                <label for="">Voornaam</label>
                <input type="text" name="first_name" id="" class="form-control" value="{{ $user->first_name }}" @error('first_name') is-invalid @enderror>
                   @error('first_name')
                     <span class="invalid-feedback" role="alert">
                       <strong>{{ $message }}</strong>
                     </span>
                  @enderror
               </div>
               <div class="mb-3">
                <label for="">Achternaam</label>
                <input type="text" name="last_name" id="" class="form-control" value="{{ $user->last_name }}" @error('last_name') is-invalid @enderror>
                   @error('last_name')
                     <span class="invalid-feedback" role="alert">
                       <strong>{{ $message }}</strong>
                     </span>
                  @enderror
               </div>
               <div class="mb-3">
                <label for="">Adres</label>
                <input type="text" name="address" id="" class="form-control" value="{{ $user->address }}" @error('address') is-invalid @enderror>
                   @error('address')
                     <span class="invalid-feedback" role="alert">
                       <strong>{{ $message }}</strong>
                     </span>
                  @enderror
               </div>
               <div class="mb-3">
                <label for="">Postcode</label>
                <input type="text" name="zipcode" id="" class="form-control" value="{{ $user->zipcode }}" @error('zipcode') is-invalid @enderror>
                   @error('zipcode')
                     <span class="invalid-feedback" role="alert">
                       <strong>{{ $message }}</strong>
                     </span>
                  @enderror
               </div>
               <div class="mb-3">
                <label for="">Telefoonnummer</label>
                <input type="tel" name="phone_number" id="" class="form-control" value="{{ $user->phone_number }}" @error('phone_number') is-invalid @enderror>
                   @error('phone_number')
                     <span class="invalid-feedback" role="alert">
                       <strong>{{ $message }}</strong>
                     </span>
                  @enderror
               </div>
               <div class="mb-3">
                <label for="">Profiel afbeelding</label>
                <input type="file" name="avatar" id="" class="form-control" value="{{ $user->avatar }}" @error('avatar') is-invalid @enderror>
                   @error('avatar')
                     <span class="invalid-feedback" role="alert">
                       <strong>{{ $message }}</strong>
                     </span>
                  @enderror
               </div>
               <div class="mb-3">
                <label for="">Email</label>
                <input type="email" name="email" id="" class="form-control" value="{{ $user->email }}" @error('email') is-invalid @enderror>
                   @error('email')
                     <span class="invalid-feedback" role="alert">
                       <strong>{{ $message }}</strong>
                     </span>
                  @enderror
               </div>





      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuleren</button>
        <button type="submit" class="btn btn-primary">Profiel opslaan</button>
      </div>
       </form>
    </div>
  </div>
</div>
                <div class="card-body">
                    @if (session()->has('message'))
                        <div class="w-100 mt-4">
                            <p class="mb-4 text-light bg-success rounded p-4">
                                {{ session()->get('message') }}
                            </p>
                        </div>
                    @endif

                </div>
                <div class="row align-items-start">
                    <div class="col-md-2">
                         <div class="mb-3">
                    <img class="card-img-top" style="width:80px; height:80px; border-radius:7pc; opacity:1;" src="{{ asset('uploads/avatar/' . $user->avatar) }}"
                    alt="{{ $user->avatar }}">
                </div>
                    </div>
                    <div class="col-md-10">

                     <div class="mb-3">
                          Naam : {{ $user->name }}
                        </div>
                        <div class="mb-3">
                          Email : {{ $user->email }}
                        </div>
                        <div class="mb-3">
                          Voornaam : {{ $user->first_name}}
                        </div>
                        <div class="mb-3">
                          Achternaam : {{ $user->last_name}}
                        </div>
                        <div class="mb-3">
                          Adres : {{ $user->address}}
                        </div>
                        <div class="mb-3">
                          Postcode : {{ $user->zipcode}}
                        </div>
                        <div class="mb-3">
                          Telefoonnummer : {{ $user->phone_number}}
                        </div>
                    </div>

                </div>







            </div>

        </div>

    </div>
@endsection
