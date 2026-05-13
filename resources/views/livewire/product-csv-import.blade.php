<div style="max-width: 700px; margin: 30px auto; padding: 25px; border: 1px solid #ddd; border-radius: 10px; background: #fff;">

    <h2 style="margin-bottom: 20px; color: #1f3b6d;">Import Product CSV</h2>

    @if (session()->has('success'))
        <div style="color: green; margin-bottom: 15px;">
            {{ session('success') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div style="color: red; margin-bottom: 15px;">
            {{ session('error') }}
        </div>
    @endif

    <div style="margin-bottom: 18px;">
        <label style="display: block; margin-bottom: 6px;">Category</label>

        <select class="form-control" wire:model.live="selectedCategoryId"
            style="width: 100%; padding: 10px 15px; border: 1px solid #ddd; border-radius: 5px;">
            <option value="">---- Select Category ----</option>

            @foreach ($category as $item)
                <option value="{{ $item->id }}">
                    {{ $item->value }}
                </option>
            @endforeach
        </select>

        @error('selectedCategoryId')
            <div style="color: red; margin-top: 6px;">{{ $message }}</div>
        @enderror
    </div>

    <div style="margin-bottom: 18px;">
        <label style="display: block; margin-bottom: 6px;">Brand</label>

        <select class="form-control" wire:model.live="selectedBrandId"
            style="width: 100%; padding: 10px 15px; border: 1px solid #ddd; border-radius: 5px;">
            <option value="">---- Select Brand ----</option>

            @foreach ($brand as $item)
                <option value="{{ $item->id }}">
                    {{$item->brandName}}
                </option>
            @endforeach
        </select>

        @error('selectedBrandId')
            <div style="color: red; margin-top: 6px;">{{ $message }}</div>
        @enderror
    </div>

    <div style="margin-bottom: 12px; padding: 10px; background: #f8f9fa; border-radius: 5px; display:none;" >
        <strong>Selected Category ID:</strong> {{ $selectedCategoryId ?: 'Not selected' }} <br>
        <strong>Selected Brand ID:</strong> {{ $selectedBrandId ?: 'Not selected' }}
    </div>

    <form wire:submit.prevent="import">

        <div style="margin-bottom: 18px;">
            <label style="display: block; margin-bottom: 6px;">Upload CSV</label>

            <input type="file" wire:model="csv" accept=".csv,.txt"
                style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">

            @error('csv')
                <div style="color: red; margin-top: 6px;">{{ $message }}</div>
            @enderror
        </div>

        <div style="display: flex; gap: 12px; flex-wrap: wrap;">
            <button type="submit"
                style="padding: 12px 24px; background: #007bff; color: white; border: none; border-radius: 6px; cursor: pointer;">
                Upload CSV
            </button>

            <button type="button" wire:click="exportCsv"
                style="padding: 12px 24px; background: green; color: white; border: none; border-radius: 6px; cursor: pointer;">
                Download CSV Format
            </button>
        </div>

    </form>

    <div wire:loading wire:target="csv,import,exportCsv" style="margin-top: 12px; color: blue;">
        Processing...
    </div>
</div>