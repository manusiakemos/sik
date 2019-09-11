<div class="dropdown">
    <button class="btn btn-dark dropdown-toggle" type="button" id="{{ $value['reward_id'] }}"
            data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
        Action
    </button>
    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="{{ $value['reward_id'] }}">
        <a class="dropdown-item btn-edit" href="{{ route('reward.show', $value['reward_id']) }}">Edit</a>
        <a class="dropdown-item btn-destroy" href="{{ route('reward.destroy', $value['reward_id']) }}">Hapus</a>
    </div>
</div>