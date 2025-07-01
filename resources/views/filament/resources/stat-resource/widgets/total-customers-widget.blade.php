<x-filament-widgets::widget column-span="full">
    <x-filament::section class="space-y-6">
        <div class="flex flex-wrap gap-4">
            {{-- إجمالي العملاء --}}
            <div class="flex-1 min-w-[250px] p-4 bg-white rounded-lg shadow flex items-center space-x-4">
                <x-heroicon-o-user-group class="w-8 h-8 text-primary-600" />
                <div>
                    <div class="text-sm font-medium text-gray-600">Total Clients</div>
                    <div class="mt-1 text-2xl font-bold text-gray-900">
                        {{ \App\Models\Client::count() }}
                    </div>
                </div>
            </div>

            {{-- أعضاء الفريق --}}
            <div class="flex-1 min-w-[250px] p-4 bg-white rounded-lg shadow flex items-center space-x-4">
                <x-heroicon-o-user class="w-8 h-8 text-green-600" />
                <div>
                    <div class="text-sm font-medium text-gray-600">Team Members</div>
                    <div class="mt-1 text-2xl font-bold text-gray-900">
                        {{ \App\Models\Admin::count() }}
                    </div>
                </div>
            </div>

            {{-- إجمالي الوثائق --}}
            <div class="flex-1 min-w-[250px] p-4 bg-white rounded-lg shadow flex items-center space-x-4">
                <x-heroicon-o-document-text class="w-8 h-8 text-indigo-600" />
                <div>
                    <div class="text-sm font-medium text-gray-600">Total Documents</div>
                    <div class="mt-1 text-2xl font-bold text-gray-900">
                        {{ \App\Models\Document::count() }}
                    </div>
                </div>
            </div>

            {{-- التحميلات هذا الشهر --}}
            <div class="flex-1 min-w-[250px] p-4 bg-white rounded-lg shadow flex items-center space-x-4">
                <x-heroicon-o-arrow-up-on-square-stack class="w-8 h-8 text-yellow-600" />
                <div>
                    <div class="text-sm font-medium text-gray-600">Uploads This Month</div>
                    <div class="mt-1 text-2xl font-bold text-gray-900">
                        {{ \App\Models\Document::whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])->count() }}
                    </div>
                </div>
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
