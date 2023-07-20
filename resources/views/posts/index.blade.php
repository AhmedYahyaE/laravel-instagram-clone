@extends('layouts.app')


@section('content')
    <div class="container">
        {{-- Show posts from the profiles that the authenticated user is FOLLOWING --}}
        @foreach($posts as $post)
            <div class="row">
                <div class="col-6 offset-3">
                    <a href="/profile/{{ $post->user->id }}">
                        <img src="/storage/{{ $post->image }}" class="w-100">
                    </a>
                </div>
            </div>

            <div class="row pt-2 pb-4">
                <div class="col-6 offset-3">
                    <div>
                        <p>
                            <span class="fw-bold">
                                <a class="text-decoration-none" href="/profile/{{ $post->user->id }}">
                                    <span class="text-dark">{{ $post->user->username }}</span>
                                </a>
                            </span> {{ $post->caption }}
                        </p>
                    </div>
                </div>
            </div>
        @endforeach

        <!-- Pagination buttons -->
        <div class="row">
            <div class="col-12 d-flex justify-content-center">
                {{ $posts->links() }} {{-- Displaying Pagination Results: https://laravel.com/docs/9.x/pagination#displaying-pagination-results --}}
            </div>
        </div>


    </div>
@endsection