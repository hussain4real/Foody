<div>
    @if(session()->has('status'))
        <div x-data="toastNotification()" x-show="show" x-init="setTimeout(() => show = false, 3000)"
             class="fixed top-0 right-0 bg-green-500 text-slate-100 py-2 px-6 mr-6 mb-6 rounded-xl shadow-lg z-50 transition duration-3000 ease-out">
            <p>{{ session('status') }}</p>
        </div>

    @endif

    <div
        class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 justify-items-center items-center gap-y-6 outline-none focus:outline-none dark:bg-slate-800 mt-4">
        @foreach($foods as $food)

            <div
                class="w-[20rem] lg:w-[22rem] h-[32rem] rounded overflow-hidden shadow bg-slate-200 backdrop-filter backdrop-blur-md bg-opacity-20">
                @if($food->media->count() > 0)
                    <div class="snap-mandatory snap-x flex overflow-scroll w-[22rem] h-[19rem]">
                        <div class="snap-start w-[22rem] flex-shrink-0">
                            <img
                                class="object-cover w-full rounded-lg"
                                src="{{$food->media[0]->getUrl()}}"
                                alt="food">
                        </div>
                        @if($food->media->count() > 1)
                            <div class="snap-start w-[22rem] flex-shrink-0">
                                <img
                                    class="object-cover w-full rounded-lg"
                                    src="{{$food->media[1]->getUrl()}}"
                                    alt="food">
                            </div>
                        @endif

                        @if($food->media->count() > 2)
                            <div class="snap-start w-[22rem] flex-shrink-0">
                                <img
                                    class="object-cover w-full rounded-lg"
                                    src="{{$food->media[2]->getUrl()}}"
                                    alt="food">
                            </div>
                        @endif
                        @if($food->media->count() > 3)
                            <div class="snap-start w-[22rem] flex-shrink-0">
                                <img
                                    class="object-cover w-full rounded-lg"
                                    src="{{$food->media[3]->getUrl()}}"
                                    alt="food">
                            </div>
                        @endif
                    </div>

                @else
                    <img
                        class="object-cover w-full h-[300px] rounded-lg"
                        src="https://images.unsplash.com/photo-1546069901-ba9599a7e63c?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2680&q=80"
                        alt="food">
                @endif


                <div class="px-6 py-4 flex flex-col h-40">
                    <div class="font-bold text-xl mb-2">{{$food->name}}</div>
                    <p class="text-gray-700 text-base grow-0">
                        {{$food->description}}
                    </p>

                    <div class="py-2 flex">
                        <a class="bg-slate-300 px-2 rounded drop-shadow-sm text-green-700 font-semibold" href=""
                           wire:navigate>
                            {{$food->user->first_name. ' ' .$food->user->last_name}}
                        </a>
                    </div>
                </div>
                <div class="flex items-center justify-between px-6 pt-2 pb-2">
                    <div
                        class="bg-slate-200 rounded-full shadow px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">{{$food->type}}</div>
                    <div
                        @class([
                            ($food->status == 'available') ?
                             'bg-red-400 rounded-full px-2 py-1 text-sm font-semibold text-slate-100 mr-2 mb-2' :
                             (($food->status == 'unavailable') ?
                             'bg-slate-500 rounded-full px-2 py-1 text-sm font-semibold text-slate-100 mr-2 mb-2' :
                             'bg-green-500 rounded-full px-2 py-1 text-sm font-semibold text-slate-100 mr-2 mb-2')
                             ])>
                        {{$food->status}}
                    </div>
                    <div class="">
                        <x-secondary-button class="hover:bg-green-400 hover:text-slate-100 hover:font-semibold">
                            hello
                        </x-secondary-button>
                    </div>
                </div>


            </div>

        @endforeach

    </div>
    {{--    {{ $foods->links() }}--}}
</div>

<script>
    function toastNotification() {
        return {
            show: true,
            timeout: setTimeout(() => {
                this.show = false
            }, 3000)
        }
    }
</script>
