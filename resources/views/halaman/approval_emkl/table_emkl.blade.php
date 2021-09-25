<template x-if="list_details_table.total">
    <section class="my-6">
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
                        <template x-if="item.status_request == 2">
                            <th class="border truncate grid grid-cols-2 gap-2 py-2 text-xs border-dashed px-2">
                                <div x-on:click='openPopupVerif(item)' class="bg-indigo-900 w-full px-1.5 py-0.5 text-white text-xs text-center cursor-pointer rounded-sm"><p>Verif</p></div>
                                <div x-on:click='openPopupReject(item)' class="bg-red-500 hover:bg-red-600 px-1.5 py-0.5 text-white text-xs text-center cursor-pointer rounded-sm">Reject</div>
                            </th>
                        </template>
                    </tr>
                </template>
            </tbody>
            </table>
    </section>
</template>
<template x-if="popup">
    <div class="h-screen w-full flex items-center justify-center fixed top-0 z-50">
        <div class="flex w-2/6 border shadow-xl justify-center">
            <div class="p-3 text-center bg-white rounded-md">
                <p class="mb-3 font-semibold">Confirmation !</p>
                <div class="text-center"><span>Apakah anda yakin ingin melanjutkan validasi data ?. click kembali untuk membatalkan !</span></div>
                <div class="mt-3 grid grid-cols-2 gap-3">
                    <template x-if="popup == 1">
                        <div x-on:click='Approved()' class="cursor-pointer bg-green-500 text-white font-semibold">Verif</div>
                    </template>
                    <template x-if="popup == 2">
                        <div x-on:click='Rejected()' class="cursor-pointer bg-green-500 text-white font-semibold">Rejected</div>
                    </template>
                    <div x-on:click='cancel()' class="cursor-pointer bg-red-500 text-white font-semibold">Batal</div>
                </div>
            </div>
        </div>
    </div>
</template>
<template x-if="showLoading">
    <div class="fixed top-0 left-0 right-0 bg-gray-500 bg-opacity-30 z-50 h-screen max-h-screen flex justify-center items-center">
        <p class="text-xs text-blue-500 font-semibold animate-bounce">Sedang mengirim permintaan ...</p>
    </div>
</template>