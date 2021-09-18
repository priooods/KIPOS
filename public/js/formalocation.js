function forms() {
    return {
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
            active_start: null,
            active_end: null,
            m_consignee_id: null,
            m_route_id: null,
            destination: null,
        },
        validation: false,
        list: [],
        init() {
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
            this.$watch("consignee", (v) => {
                this.desc_consignee = null;
                if (v) {
                    this.consignee_box = true;
                    fetch("/index/call_consigne?code=" + v)
                        .then((res) => res.json())
                        .then((e) => {
                            this.list = e;
                        });
                } else return (this.consignee_box = false);
            });
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
        selectPolice(id, pol, exp) {
            this.form.m_trucks_id = id;
            this.police = pol;
            return (this.police_box = false), (this.expire_date = exp);
        },
        selectConsigne(id, code, name) {
            this.form.m_consignee_id = id;
            this.consignee = code;
            return (this.consignee_box = false), (this.desc_consignee = name);
        },
        selectDriver(id, name) {
            this.driver = name;
            return (this.driver_box = false), (this.form.m_drivers_id = id);
        },
        selectRoutes(id, name) {
            this.routes = name;
            return (this.routes_box = false), (this.form.m_route_id = id);
        },
        sending() {
            if (
                !this.expire_date ||
                !this.form.m_route_id ||
                !this.form.m_drivers_id ||
                !this.desc_consignee ||
                !this.form.active_start ||
                !this.form.active_end ||
                !this.form.ritase
            ) {
                this.validation = true;
                setTimeout(() => {
                    return (this.validation = false);
                }, 3000);
            } else {
                fetch("/new_emkls", {
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
                    .then((e) => console.log(e));
            }
            // this.failure_police = true;
            // if (!expire_date.value) this.failure = false;
            // console.log(this.police);
        },
    };
}
