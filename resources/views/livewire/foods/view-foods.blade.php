<div>
    <div
        class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 justify-items-center items-center gap-y-6 outline-none focus:outline-none dark:bg-slate-800">
        @foreach($foods as $food)

            <div
                class="w-[20rem] lg:w-[22rem] rounded overflow-hidden shadow bg-slate-200 backdrop-filter backdrop-blur-md bg-opacity-20">
                <img
                    class="object-cover w-full h-[300px] rounded-lg"
                    src="https://images.unsplash.com/photo-1546069901-ba9599a7e63c?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1180&q=80"
                    alt="food">
                <div class="px-6 py-4">
                    <div class="font-bold text-xl mb-2">{{$food->name}}</div>
                    <p class="text-gray-700 text-base">
                        {{$food->description}}
                    </p>
                    <div class="py-2 flex">
                        <a class="bg-slate-300 px-2 rounded drop-shadow-sm text-green-700 font-semibold" href=""
                           wire:navigate>
                            {{$food->user->first_name. ' ' .$food->user->last_name}}
                        </a>
                    </div>
                </div>
                <div class="px-6 pt-4 pb-2">
                    <span
                        class="inline-block bg-slate-200 rounded-full shadow px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">{{$food->type}}</span>
                    <span
                            @class([
        ($food->status == 'available') ?
         'inline-block bg-red-400 rounded-full px-1 py-1 text-sm font-semibold text-slate-100 mr-2 mb-2' :
         (($food->status == 'unavailable') ?
         'inline-block bg-slate-500 rounded-full px-1 py-1 text-sm font-semibold text-slate-100 mr-2 mb-2' :
         'inline-block bg-green-500 rounded-full px-1 py-1 text-sm font-semibold text-slate-100 mr-2 mb-2')
         ])>
                            {{$food->status}}
                        </span>
                    <span
                        class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">#hello</span>
                </div>
            </div>

        @endforeach

    </div>
    {{ $foods->links() }}
</div>
