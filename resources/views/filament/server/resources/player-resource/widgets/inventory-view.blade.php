@php
    $inventory = $getState() ?? [];
    $getItem = function($slot) use ($inventory) {
        foreach ($inventory as $item) {
            if (isset($item['slot']) && $item['slot'] == $slot) return $item;
        }
        return null;
    };
@endphp

<div class="inv-wrapper p-4 border border-gray-200 dark:border-white/10 rounded-xl bg-gray-50 dark:bg-white/5 w-fit max-w-full text-gray-900 dark:text-white">
    
    {{-- Main Inventory Grid --}}
    <div class="flex flex-col gap-2 shrink-0">
        {{-- Internal Slots (Row 1-3) --}}
        @for ($row = 0; $row < 3; $row++)
            <div class="flex gap-2 slot-row">
                @for ($col = 0; $col < 9; $col++)
                    @php 
                        $slotId = 9 + ($row * 9) + $col;
                        $item = $getItem($slotId);
                    @endphp
                    <div class="inv-slot relative flex items-center justify-center bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm transition hover:ring-2 hover:ring-primary-500 hover:border-primary-500 group shrink-0"
                         title="{{ $item['id'] ?? 'Empty' }}">
                        @if ($item)
                            <img src="https://assets.mcasset.cloud/1.20.4/assets/minecraft/textures/item/{{ str_replace('minecraft:', '', $item['id']) }}.png" 
                                 class="inv-img rendering-pixelated"
                                 onerror="this.onerror=null;this.src='https://assets.mcasset.cloud/1.20.4/assets/minecraft/textures/block/{{ str_replace('minecraft:', '', $item['id']) }}.png'" />
                            @if (($item['count'] ?? 1) > 1)
                                <span class="inv-count absolute bottom-0 right-0 font-bold px-1 pt-0.5 rounded-tl-sm shadow-sm leading-none">
                                    {{ $item['count'] }}
                                </span>
                            @endif
                            {{-- Tooltip on hover --}}
                            <div class="absolute bottom-full mb-1 hidden group-hover:block z-20 whitespace-nowrap bg-gray-900 text-white text-xs px-2 py-1 rounded shadow-lg">
                                {{ $item['id'] }}
                            </div>
                        @endif
                    </div>
                @endfor
            </div>
        @endfor

        {{-- Hotbar (Row 0) --}}
        <div class="flex gap-2 mt-2 slot-row">
            @for ($col = 0; $col < 9; $col++)
                @php 
                    $item = $getItem($col);
                @endphp
                <div class="inv-slot relative flex items-center justify-center bg-white dark:bg-gray-800 border-2 border-gray-300 dark:border-gray-600 rounded-md shadow-sm transition hover:ring-2 hover:ring-primary-500 hover:border-primary-500 group shrink-0"
                     title="{{ $item['id'] ?? 'Empty' }}">
                    @if ($item)
                        <img src="https://assets.mcasset.cloud/1.20.4/assets/minecraft/textures/item/{{ str_replace('minecraft:', '', $item['id']) }}.png" 
                             class="inv-img rendering-pixelated"
                             onerror="this.onerror=null;this.src='https://assets.mcasset.cloud/1.20.4/assets/minecraft/textures/block/{{ str_replace('minecraft:', '', $item['id']) }}.png'" />
                        @if (($item['count'] ?? 1) > 1)
                            <span class="inv-count absolute bottom-0 right-0 font-bold px-1 pt-0.5 rounded-tl-sm shadow-sm leading-none">
                                {{ $item['count'] }}
                            </span>
                        @endif
                        <div class="absolute bottom-full mb-1 hidden group-hover:block z-20 whitespace-nowrap bg-gray-900 text-white text-xs px-2 py-1 rounded shadow-lg">
                             {{ $item['id'] }}
                        </div>
                    @endif
                </div>
            @endfor
        </div>
    </div>

    {{-- Armor & Offhand Column --}}
    <div class="inv-armor flex gap-2 border-gray-200 dark:border-white/10 shrink-0">
        @foreach ([103, 102, 101, 100] as $armorSlot)
            @php 
                $item = $getItem($armorSlot); 
                $icons = [103 => 'helmet', 102 => 'chestplate', 101 => 'leggings', 100 => 'boots'];
                $placeholder = $icons[$armorSlot] ?? 'armor';
            @endphp
            <div class="inv-slot relative flex items-center justify-center bg-gray-100 dark:bg-gray-900 border border-gray-300 dark:border-gray-700 rounded-md shadow-inner group shrink-0"
                 title="{{ $item['id'] ?? ucfirst($placeholder) }}">
                @if ($item)
                    <img src="https://assets.mcasset.cloud/1.20.4/assets/minecraft/textures/item/{{ str_replace('minecraft:', '', $item['id']) }}.png"
                         class="inv-img rendering-pixelated"
                         onerror="this.onerror=null;this.src='https://assets.mcasset.cloud/1.20.4/assets/minecraft/textures/block/{{ str_replace('minecraft:', '', $item['id']) }}.png'" />
                @else
                   <span class="text-gray-300 dark:text-gray-600 text-xs text-center leading-none opacity-50">{{ substr($placeholder, 0, 1) }}</span>
                @endif
            </div>
        @endforeach

        {{-- Offhand --}}
        <div class="inv-slot relative flex items-center justify-center ml-2 offhand-slot bg-gray-100 dark:bg-gray-900 border border-gray-300 dark:border-gray-700 rounded-md shadow-inner group shrink-0"
             title="Offhand">
            @php $item = $getItem(-106); @endphp
             @if ($item)
                 <img src="https://assets.mcasset.cloud/1.20.4/assets/minecraft/textures/item/{{ str_replace('minecraft:', '', $item['id']) }}.png"
                      class="inv-img rendering-pixelated"
                      onerror="this.onerror=null;this.src='https://assets.mcasset.cloud/1.20.4/assets/minecraft/textures/block/{{ str_replace('minecraft:', '', $item['id']) }}.png'" />
                 @if (($item['count'] ?? 1) > 1)
                     <span class="inv-count absolute bottom-0 right-0 font-bold px-1 pt-0.5 rounded-tl-sm shadow-sm leading-none">
                         {{ $item['count'] }}
                     </span>
                 @endif
            @else
                <span class="inv-off-text text-gray-400 font-medium">OFF</span>
            @endif
        </div>
    </div>
</div>

<style>
    /* Desktop Default Styles */
    .inv-wrapper {
        display: flex;
        flex-direction: row;
        align-items: flex-start;
        gap: 1rem; /* gap-4 */
        overflow: visible;
    }
    .inv-slot {
        width: 2.5rem; /* w-10 */
        height: 2.5rem; /* h-10 */
    }
    .inv-img {
        width: 1.75rem; /* w-7 */
        height: 1.75rem; /* h-7 */
    }
    .inv-count {
        font-size: 9px;
        color: #1f2937; /* gray-800 */
        background-color: #e5e7eb; /* gray-200 */
    }
    .dark .inv-count {
        color: #ffffff;
        background-color: rgba(0, 0, 0, 0.6);
    }
    .inv-off-text {
        font-size: 10px;
    }
    .inv-armor {
        flex-direction: column;
        padding-left: 1rem; /* pl-4 */
        border-left-width: 1px; /* border-l */
    }
    .offhand-slot {
        margin-top: 0.5rem; /* mt-2 */
        margin-left: 0;
    }
    .slot-row {
        gap: 0.5rem; /* gap-2 */
    }

    /* Mobile Responsive Overrides */
    @media (max-width: 640px) {
        .inv-wrapper {
            flex-direction: column;
            align-items: center;
            gap: 0.5rem; /* gap-2 */
            overflow-x: auto;
            padding: 0.75rem; /* p-3 */
        }
        .inv-slot {
            width: 2rem; /* w-8 */
            height: 2rem; /* h-8 */
        }
        .inv-img {
            width: 1.5rem; /* w-6 */
            height: 1.5rem; /* h-6 */
        }
        .inv-count {
            font-size: 8px;
        }
        .inv-off-text {
            font-size: 8px;
        }
        .inv-armor {
            flex-direction: row;
            padding-left: 0;
            border-left-width: 0;
            padding-top: 0.5rem; /* pt-2 */
            border-top-width: 1px; /* border-t */
            margin-top: 0.5rem; /* mt-2 */
            justify-content: center;
            width: 100%;
        }
        .offhand-slot {
            margin-top: 0;
            margin-left: 0.5rem;
        }
        .slot-row {
            gap: 0.25rem; /* gap-1 */
        }
    }

    .rendering-pixelated {
        image-rendering: pixelated;
        image-rendering: -moz-crisp-edges;
        image-rendering: crisp-edges;
    }
</style>
