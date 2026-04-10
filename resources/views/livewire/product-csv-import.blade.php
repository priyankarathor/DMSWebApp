<div style="max-width: 600px; margin: 30px auto; padding: 20px; border: 1px solid #ddd; border-radius: 10px;">
    <h2 style="margin-bottom: 20px;">Import Product CSV</h2>

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

    <form wire:submit.prevent="import">
        <div style="margin-bottom: 15px;">
            <input type="file" wire:model="csv" accept=".csv">
            @error('csv')
                <div style="color: red;">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" style="padding: 10px 20px; background: #007bff; color: white; border: none; border-radius: 5px;">
            Upload CSV
        </button>
    </form>

    <div wire:loading wire:target="csv,import" style="margin-top: 10px; color: blue;">
        Processing...
    </div>
</div>