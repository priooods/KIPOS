var form = document.getElementById("hide_from");
var end = document.getElementById("hide_end");

form.innerText = new moment().format("YYYY-MM-DD");
end.innerText = new moment().format("YYYY-MM-DD");
var start = document.getElementById("form_dats");
var ended = document.getElementById("end_dats");
start.addEventListener("change", () => {
    form.innerText = moment(start.value).format("YYYY-MM-DD");
});
ended.addEventListener("change", () => {
    end.innerText = moment(ended.value).format("YYYY-MM-DD");
});
function details() {
    return {
        message: "",
        showLoading: false,
        popUpEmail: false,
        error_code: 0,
        police: null,
        consignee: null,
        driver: null,
        routes: null,
        desc_consignee: null,
        expire_date: null,
        driver_box: false,
        police_box: false,
        routes_box: false,
        consignee_box: false,
        form: {
            m_trucks_id: null,
            m_drivers_id: null,
            ritase: null,
            active_start: new moment().format("YYYY-MM-DD"),
            active_end: new moment().format("YYYY-MM-DD"),
            m_route_id: null,
            created: new Date(),
            destination: null,
        },
        validation: 0,
        list: [],
        details_table: {},
        list_details_table: [],
        init() {
            this.getDetailsAllocation();
            this.$watch("police", (v) => {
                this.expire_date = null;
                if (v) {
                    this.police_box = true;
                    fetch("/index/call_truck?nopol=" + v)
                        .then((res) => res.json())
                        .then((e) => {
                            this.list = e;
                        });
                } else return (this.police_box = false);
            });
            // this.$watch("consignee", (v) => {
            //     this.desc_consignee = null;
            //     if (v) {
            //         this.consignee_box = true;
            //         fetch("/index/call_consigne?code=" + v)
            //             .then((res) => res.json())
            //             .then((e) => {
            //                 this.list = e;
            //             });
            //     } else return (this.consignee_box = false);
            // });
            this.$watch("driver", (v) => {
                this.form.m_drivers_id = null;
                if (v) {
                    this.driver_box = true;
                    fetch("/index/call_driver?name=" + v)
                        .then((res) => res.json())
                        .then((e) => {
                            this.list = e;
                        });
                } else return (this.driver_box = false);
            });
            this.$watch("routes", (v) => {
                this.form.m_route_id = null;
                if (v) {
                    this.routes_box = true;
                    fetch("/index/call_routes?description=" + v)
                        .then((res) => res.json())
                        .then((e) => {
                            this.list = e;
                        });
                } else return (this.routes_box = false);
            });
        },
        getDetailsAllocation() {
            fetch("/details_emkls", {
                method: "get",
            })
                .then((res) => res.json())
                .then((e) => {
                    console.log(e);
                    this.desc_consignee = e.data.consignee;
                    return (
                        (this.details_table = e.data),
                        (this.list_details_table = e.list)
                    );
                });
        },
        selectPolice(id, pol, exp) {
            this.form.m_trucks_id = id;
            this.police = pol;
            return (this.police_box = false), (this.expire_date = exp);
        },
        // selectConsigne(id, code, name) {
        //     this.form.m_consignee_id = id;
        //     this.consignee = code;
        //     return (this.consignee_box = false), (this.desc_consignee = name);
        // },
        selectDriver(id, name) {
            this.driver = name;
            return (this.driver_box = false), (this.form.m_drivers_id = id);
        },
        selectRoutes(id, name) {
            this.routes = name;
            this.form.destination = name;
            return (this.routes_box = false), (this.form.m_route_id = id);
        },
        sending() {
            if (
                !this.expire_date ||
                !this.form.m_route_id ||
                !this.form.m_drivers_id ||
                !this.form.active_start ||
                !this.form.active_end ||
                !this.form.ritase
            ) {
                this.validation = 1;
                setTimeout(() => {
                    return (this.validation = 0);
                }, 3000);
            } else {
                this.showLoading = true;
                fetch(window.location.origin + "/new_emkls", {
                    method: "post",
                    headers: {
                        Accept: "application/json",
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                            "content"
                        ),
                    },
                    body: JSON.stringify(this.form),
                })
                    .then((res) => res.json())
                    .then((e) => {
                        if (e.error_code)
                            return (
                                (this.showLoading = false),
                                (this.validation = 2),
                                (this.message = e.error_message),
                                (this.error_code = e.error_code),
                                setTimeout(() => {
                                    this.validation = 0;
                                }, 3000)
                            );
                        this.getDetailsAllocation();
                        return (
                            (this.showLoading = false),
                            (this.validation = 2),
                            (this.message = "Data Berhasil ditambahkan !"),
                            (this.error_code = e.error_code),
                            setTimeout(() => {
                                this.validation = 0;
                            }, 3000)
                        );
                    });
            }
        },
        sendEmail(data) {
            this.showLoading = true;
            fetch(window.location.origin + "/sendemail", {
                method: "post",
                headers: {
                    Accept: "application/json",
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                body: JSON.stringify(data),
            })
                .then((res) => res.json())
                .then((e) => {
                    console.log(e, "data input");
                    this.getDetailsAllocation();
                    return (
                        (this.showLoading = false),
                        (this.validation = 2),
                        (this.message = e.error_message),
                        (this.error_code = e.error_code),
                        setTimeout(() => {
                            this.validation = 0;
                        }, 3000)
                    );
                });
        },
        sendList() {
            this.showLoading = true;
            fetch(window.location.origin + "/send_request", {
                method: "get",
                headers: {
                    Accept: "application/json",
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
            })
                .then((res) => res.json())
                .then((e) => {
                    if (e.data) {
                        this.popUpEmail = true;
                    }
                    this.getDetailsAllocation();
                    return (
                        (this.showLoading = false),
                        (this.validation = 2),
                        (this.message = e.error_message),
                        (this.error_code = e.error_code),
                        setTimeout(() => {
                            this.validation = 0;
                        }, 3000),
                        setTimeout(() => {
                            this.popUpEmail = false;
                        }, 6000)
                    );
                });
        },
        deleteList(id) {
            fetch(window.location.origin + "/delete_emkls", {
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
                    this.getDetailsAllocation();
                    return (
                        (this.validation = 2),
                        (this.message = e.error_message),
                        (this.error_code = e.error_code),
                        setTimeout(() => {
                            this.validation = 0;
                        }, 3000)
                    );
                });
        },
    };
}
