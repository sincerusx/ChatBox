<div class="media">
    <a href="" class="pull-left">
        <img class="media-object" src="{{ $user->getAvatarURL() }}" alt="{{ $user->getNameOrUsername() }}">
    </a>
    <div class="media-body">
        <h4 class="media-heading">
            <a href="#">
                {{ $user->getNameOrUsername() }}
            </a>
        </h4>
        @if ($user->location)
            <p>{{ $user->location }}</p>
        @endif
    </div>
</div>
