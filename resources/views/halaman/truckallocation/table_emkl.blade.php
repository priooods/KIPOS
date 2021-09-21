<template x-if="list_details_table.total">
    <section class="my-6">
        {{-- <template x-for="(item,i) in list_details_table.data">
            <template x-if="item.status_request == 0"> --}}
                <div class="flex justify-end mb-4">
                    <div x-on:click="sendList()" class="inline-flex rounded-sm bg-indigo-900 text-white px-2 py-1 cursor-pointer text-xs font-semibold">Kirim Request</div>
                </div>
            {{-- </template>
        </template> --}}
        <table class="border-collapse table-fixed w-full whitespace-no-wrap bg-white table-striped relative">
            <thead>
                <tr class="text-center rounded-md text-xs font-semibold bg-blue-200">
                    <th class="border text-xs border-dashed py-1.5 w-1/4">No</th>
                    <th class="border text-xs border-dashed w-2/4">Nomor Polisi</th>
                    <th class="border text-xs border-dashed w-2/4">Driver</th>
                    {{-- <th class="border text-xs border-dashed w-1/4">Ritase</th> --}}
                    <th class="border text-xs border-dashed w-2/4">Valid From</th>
                    <th class="border text-xs border-dashed w-2/4">Valid Until</th>
                    <th class="border text-xs border-dashed w-2/4">Consignee</th>
                    <th class="border text-xs border-dashed w-2/4">Route</th>
                    <th class="border text-xs border-dashed w-2/4">Status Request</th>
                    <th class="border text-xs border-dashed w-2/4">Send</th>
                    <th class="border text-xs border-dashed w-2/4">Delete</th>
                </tr>
            </thead>
            <tbody>
                <template x-for="(item,i) in list_details_table.data">
                    <tr class="text-center hover:bg-blue-50 font-semibold">
                        <th class="border text-xs border-dashed w-1/4" x-text="i + 1"></th>
                        <th class="border text-xs border-dashed w-2/4" x-text="item.mobil.nopol"></th>
                        <template x-if="item.m_drivers_id">
                            <th class="border text-xs border-dashed w-2/4" x-text="item.driver.name"></th>
                        </template>
                        <template x-if="item.m_drivers_id == null">
                            <th class="border text-xs border-dashed w-2/4">Driver tidak terdaftar</th>
                        </template>
                        <th class="border text-xs border-dashed w-2/4" x-text="item.active_start"></th>
                        <th class="border text-xs border-dashed w-2/4" x-text="item.active_end"></th>
                        <th class="border text-xs border-dashed w-2/4" x-text="item.consigne.name "></th>
                        <th class="border text-xs border-dashed w-2/4" x-text="item.route.description"></th>
                        <th class="border text-xs border-dashed w-2/4" 
                            x-text="item.status_request == 0 ? 'Belum Dikirim' : item.status_request == 1 ? 'Available' 
                                : item.status_request == 2 ? 'Non Available' : item.status_request == 3 ? 'Approved by GTO' 
                                : item.status_request == 4 ? 'Rejected by GTO' : item.status_request == 5 ? ' Approved by EMKL'
                                : 'Rejected by EMKL'">
                        </th>
                        <th class="border text-xs border-dashed py-2 px-2 w-2/4">
                            <template x-if="item.status_request == 2">
                                <div x-on:click='sendEmail(item)' class="bg-indigo-900 w-full px-1.5 py-0.5 text-white text-xs text-center cursor-pointer rounded-sm"><p>Send e-mail</p></div>
                            </template>
                        </th>
                        <th class="border text-xs border-dashed py-2 px-2 w-2/4">
                            <template x-if="item.status_request == 0">
                                <div x-on:click='deleteList(item.id)' class="bg-red-500 hover:bg-red-600 px-1.5 py-0.5 text-white text-xs text-center cursor-pointer rounded-sm">Delete</div>
                            </template>
                        </th>
                    </tr>
                </template>
            </tbody>
            </table>
    </section>
</template>