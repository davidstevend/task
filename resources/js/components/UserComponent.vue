<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <b>LISTADO DE USUARIOS</b>

                        <!-- Button modal -->
                        <button
                            @click="
                                update = false;
                                openModal();
                            "
                            type="button"
                            class="btn btn-primary"
                        >
                            NUEVO USUARIO
                        </button>

                        <!-- Modal -->
                        <div class="modal" :class="{ show: modal }">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5
                                            class="modal-title"
                                            id="exampleModalLabel"
                                        >
                                            {{ titleModal }}
                                        </h5>
                                        <button
                                            @click="closeModal()"
                                            type="button"
                                            class="btn-close"
                                            data-bs-dismiss="modal"
                                            aria-label="Close"
                                        ></button>
                                    </div>
                                    <div class="modal-body">
                                        <div>
                                            <label for="name"
                                                ><b>Nombre</b></label
                                            >
                                            <input
                                                v-model="user.name"
                                                type="text"
                                                class="form-control"
                                                id="name"
                                                placeholder="Nombre"
                                                name="name"
                                            />
                                        </div>
                                        <div>
                                            <label for="email"
                                                ><b>Email</b></label
                                            >
                                            <input
                                                v-model="user.email"
                                                type="text"
                                                class="form-control"
                                                id="email"
                                                placeholder="Email"
                                                name="email"
                                            />
                                        </div>
                                        <div>
                                            <label for="password"
                                                ><b>password</b></label
                                            >
                                            <input
                                                v-model="user.password"
                                                type="password"
                                                class="form-control"
                                                id="password"
                                                placeholder="password"
                                                name="password"
                                            />
                                        </div>
                                        <div>
                                            <label for="password-confirm"
                                                ><b>password</b></label
                                            >
                                            <input
                                                v-model="user.password_confirm"
                                                type="password"
                                                class="form-control"
                                                id="password-confirm"
                                                placeholder="password-confirm"
                                                name="password-confirm"
                                            />
                                        </div>

                                        <br />

                                        <!-- <div>
                        <label for="finished"><b>Finalizada</b></label>
                        <input type="radio" id="finished" name="finished" value="SI">
                            <label for="finished">SI</label>
                            <input type="radio" id="finished" name="finished" value="NO">
                            <label for="finished">NO</label><br>
                    </div> -->
                                    </div>
                                    <div class="modal-footer">
                                        <button
                                            @click="closeModal()"
                                            type="button"
                                            class="btn btn-secondary"
                                            data-bs-dismiss="modal"
                                        >
                                            Cerrar
                                        </button>
                                        <button
                                            @click="save()"
                                            class="btn btn-primary"
                                        >
                                            Guardar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body table-responsive">
                        <div class="row">
                            <div class="col-lg-8 col-md-8">
                                <!-- <label for="user"><b>buscar</b></label> -->
                                <input
                                    type="search"
                                    class="form-control"
                                    id="search"
                                    placeholder="Buscar"
                                    name="search"
                                    autocomplete="off"
                                    v-model="search"
                                    v-on:keyup.enter="buscarUser"
                                />
                            </div>
                            <div class="col-lg-4 col-md-4">
                                <button
                                    @click="buscarUser()"
                                    class="btn btn-info"
                                >
                                    BUSCAR
                                </button>
                            </div>
                        </div>
                        <br />
                        <br />
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">NOMBRE</th>
                                    <th scope="col">EMAIL</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="user in users" :key="user.id">
                                    <th scope="row">{{ user.id }}</th>
                                    <td>{{ user.name }}</td>
                                    <td>{{ user.email }}</td>

                                    <td>
                                        <button
                                            @click="
                                                update = true;
                                                openModal(user);
                                            "
                                            class="btn btn-warning"
                                        >
                                            EDITAR
                                        </button>
                                    </td>
                                    <td>
                                        <button
                                            @click="eliminar(user.id)"
                                            class="btn btn-danger"
                                        >
                                            ELIMINAR
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            user: {
                name: "",
                email: "",
                password: "",
                password_confirm: "",
            },
            id: 0,
            update: true,
            modal: 0,
            titleModal: " ",
            users: [],
            search: "",
        };
    },

    methods: {
        async list() {
            const res = await axios.get("users");
            this.users = res.data;
        },
        async buscarUser() {
            const res = await axios.get("users", {
                params: {
                    search: this.search,
                },
            });
            this.users = res.data;
        },

        async eliminar(id) {
            const res = await axios.delete("users/" + id);
            this.list();
        },

        async save() {
            if (this.update) {
                const res = await axios.put("users/" + this.id, this.user);
            } else {
              console.log('sjs')
                const res = await axios.post("users", this.user);
            }
            this.closeModal();
            this.list();
        },

        openModal(data = {}) {
            this.modal = 1;

            if (this.update) {
                this.modal = data.id;
                this.titleModal = "Editar usuario";
                this.id = data.id;

                this.user.name = data.name;
                this.user.email = data.email;
            } else {
                this.id = 0;
                this.modal = 1;
                this.titleModal = "Crear usuario";
                this.user.name = "";
                this.user.email = "";
            }
        },

        closeModal() {
            this.modal = 0;
        },
    },

    created() {
        this.list();
    },
};
</script>

<style>
.show {
    display: list-item;
    opacity: 1;
    background: rgba(44, 38, 75, 0.849);
}
</style>
