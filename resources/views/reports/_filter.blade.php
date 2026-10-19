{{-- Filter rentang tanggal. Param: $action (URL), $startDate, $endDate --}}
<div class="card">
    <div class="card__body">
        <form action="{{ $action }}" method="GET" class="flex flex-wrap items-end gap-4">
            <div class="field">
                <label for="start_date" class="field__label">Tanggal Mulai</label>
                <input type="date" name="start_date" id="start_date" value="{{ $startDate }}" class="input">
            </div>
            <div class="field">
                <label for="end_date" class="field__label">Tanggal Akhir</label>
                <input type="date" name="end_date" id="end_date" value="{{ $endDate }}" class="input">
            </div>
            <button type="submit" class="button button--primary"><x-icon name="search" /> Filter</button>
        </form>
    </div>
</div>
