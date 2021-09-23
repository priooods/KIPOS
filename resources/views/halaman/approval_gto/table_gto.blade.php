<template x-if="list_details_table.total">
    <section class="my-6">
        <template x-for="(item,i) in list_details_table.data">
            <template x-if="item.status_request == 0">
                <div class="flex justify-end mb-4">
                    <div x-on:click="sendList()" class="inline-flex rounded-sm bg-indigo-900 text-white px-2 py-1 cursor-pointer text-xs font-semibold">Kirim Request</div>
                </div>
            </template>
        </template>
        <table class="border-collapse table-fixed w-full whitespace-no-wrap bg-white table-striped relative">
            <thead>
                <tr class="text-center rounded-md text-xs font-semibold bg-blue-200">
                    <th class="border text-xs border-dashed py-1.5 w-1/4">No</th>
                    <th class="border text-xs border-dashed w-2/4">Nomor Polisi</th>
                    <th class="border text-xs border-dashed w-2/4">Driver</th>
                    <th class="border text-xs border-dashed w-2/4">Valid From</th>
                    <th class="border text-xs border-dashed w-2/4">Valid Until</th>
                    <th class="border text-xs border-dashed w-2/4">Consignee</th>
                    <th class="border text-xs border-dashed w-2/4">Route</th>
                    <th class="border text-xs border-dashed w-2/4">Status Request</th>
                    <th class="border text-xs border-dashed w-2/4">Action</th>
                </tr>
            </thead>
            <tbody>
                <template x-for="(item,i) in list_details_table.data">
                    <tr class="text-center hover:bg-blue-50 font-semibold">
                        <th class="border text-xs border-dashed w-1/4" x-text="i + 1"></th>
                        <th class="border text-xs border-dashed w-2/4" x-text="item.mobil.nopol"></th>
                        <th class="border text-xs border-dashed w-2/4" x-text="item.driver ? item.driver.name : 'tidak terdaftar !'"></th>
                        <th class="border text-xs border-dashed w-2/4" x-text="item.active_start"></th>
                        <th class="border text-xs border-dashed w-2/4" x-text="item.active_end"></th>
                        <th class="border text-xs border-dashed w-2/4" x-text="item.consigne.name"></th>
                        <th class="border text-xs border-dashed w-2/4" x-text="item.route.description"></th>
                        <th class="border text-xs border-dashed w-2/4" 
                            x-text="item.status_request == 1 ? 'Available' 
                                : item.status_request == 2 ? 'Non Available' : item.status_request == 3 ? 'Approved by GTO' 
                                : item.status_request == 4 ? 'Rejected by GTO' : item.status_request == 5 ? ' Approved by EMKL'
                                : 'Rejected by EMKL'">
                        </th>
                        <th class="border text-xs border-dashed py-2 px-2 w-2/4">
                            <template x-if="item.status_request == 1">
                                <div class="grid gap-2 grid-cols-2">
                                    <div x-on:click='Approved(item)' class="bg-indigo-900 w-full px-1.5 py-0.5 text-white text-xs text-center cursor-pointer rounded-sm"><p>Verif</p></div>
                                    <div x-on:click='Rejected(item.id)' class="bg-red-500 hover:bg-red-600 px-1.5 py-0.5 text-white text-xs text-center cursor-pointer rounded-sm">Reject</div>
                                </div>
                            </template>
                            <template x-if="item.status_request != 1">
                                <p>Data Terproses</p>
                            </template>
                        </th>
                    </tr>
                </template>
            </tbody>
            </table>
    </section>
</template>
<template x-if="validation">
    <div class="w-full py-3 z-50 bg-red-100 text-red-500 left-0 text-sm shadow-md fixed z-40 top-0" role="alert">
        <div class="container mx-auto">
            <strong x-text="message"></strong>
        </div>
    </div>
</template>