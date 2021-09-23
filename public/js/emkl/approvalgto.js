function detail_gto() {
    return {
        showLoading: false,
        message: "",
        validation: 0,
        details_table: {},
        list_details_table: [],
        init() {
            this.getDetailsGto();
        },
        Approved(value) {
            datas = {
                id: value.id,
                t_project_headers_id: value.t_project_headers_id,
                t_request_allocation_truck_detail_id:
                    value.t_request_allocation_truck_detail_id,
                m_drivers_id: value.m_drivers_id,
                m_trucks_id: value.m_trucks_id,
                ritase: value.ritase,
                active_start: value.active_start,
                active_end: value.active_end,
                m_consignee_id: value.m_consignee_id,
                m_route_id: value.m_route_id,
                destination: value.destination,
            };
            this.showLoading = true;
            fetch("/approve_gto", {
                method: "post",
                headers: {
                    Accept: "application/json",
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                body: JSON.stringify(datas),
            })
                .then((res) => res.json())
                .then((e) => {
                    console.log(e, "result request !");
                    this.getDetailsGto();
                    if (e.error_code) {
                        this.validation = 1;
                        return (
                            (this.message = e.error_message),
                            (this.showLoading = false),
                            setTimeout(() => {
                                this.validation = 0;
                            }, 3000)
                        );
                    }
                    // console.log(e);
                    return (this.showLoading = false), this.getDetailsGto();
                });
        },
        Rejected(id) {
            this.showLoading = true;
            fetch("/rejected_gto", {
                method: "post",
                headers: {
                    Accept: "application/json",
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                body: JSON.stringify({ id: id }),
            })
                .then((res) => res.json())
                .then((e) => {
                    return (this.showLoading = false), this.getDetailsGto();
                });
        },
        getDetailsGto() {
            fetch("/details_gto", {
                method: "get",
            })
                .then((res) => res.json())
                .then((e) => {
                    console.log(e.list);
                    return (
                        (this.details_table = e.data),
                        (this.list_details_table = e.list)
                    );
                });
        },
    };
}
