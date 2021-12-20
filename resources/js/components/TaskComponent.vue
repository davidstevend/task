<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <b>LISTADO DE TAREAS</b>

            <!-- Button modal -->
            <button
              @click="
                update = false;
                openModal();
              "
              type="button"
              class="btn btn-primary"
            >
              NUEVA TAREA
            </button>

            <!-- Modal -->
            <div class="modal" :class="{ show: modal }">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
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
                      <label for="task"><b>Tarea</b></label>
                      <input
                        v-model="task.task"
                        type="text"
                        class="form-control"
                        id="task"
                        placeholder="Nombre de la Tarea"
                        name="task"
                      />
                    </div>
                    <div>
                      <label for="description"><b>Descripción</b></label>
                      <input
                        v-model="task.description"
                        type="text"
                        class="form-control"
                        id="description"
                        placeholder="Descripción de la Tarea"
                        name="description"
                      />
                    </div>
                    <div>
                      <label for="expiration_date"
                        ><b>Fecha de Vencimiento</b></label
                      >
                      <input
                        v-model="task.expiration_date"
                        type="date"
                        class="form-control"
                        id="expiration_date"
                        name="expiration_date"
                      />
                    </div>
                    <br />
                    <div>
                      <label for="finished6"><b>Finalizada: </b></label>
                      <select
                        name="finished"
                        id="finished"
                        v-model="task.finished"
                      >
                        <option value="NO">NO</option>
                        <option value="SI">SI</option>
                      </select>
                    </div>
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
                      type="button"
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
                <div class="col-lg-8 col-md-8 ">
              <!-- <label for="task"><b>buscar</b></label> -->
              <input
                type="search"
                class="form-control"
                id="search"
                placeholder="Buscar Tarea"
                name="search"
                autocomplete="off"
                v-model="search"
              />
              {{ search }}
                </div>
                <div class="col-lg-4 col-md-4 ">
              <button type="button" class="btn btn-primary">
              <!-- <button @click="buscar()" type="button" class="btn btn-primary"> -->
                Guardar
              </button>
                </div>
            </div>
            <br>
            <br>
            <table class="table table-striped table-hover">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">NOMBRE</th>
                  <th scope="col">DESCRIPCION</th>
                  <th scope="col">FECHA CREACION</th>
                  <th scope="col">FECHA EXPIRACIÓN</th>
                  <th scope="col">TERMINADA</th>
                  <th scope="col" colspan="2" class="text-center">ACCIONES</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="task in tasks" :key="task.id">
                  <th scope="row">{{ task.id }}</th>
                  <td>{{ task.task }}</td>
                  <td>{{ task.description }}</td>
                  <td>{{ task.date }}</td>
                  <td>{{ task.expiration_date }}</td>
                  <td>{{ task.finished }}</td>
                  <td>
                    <button
                      @click="
                        update = true;
                        openModal(task);
                      "
                      class="btn btn-warning"
                    >
                      EDITAR
                    </button>
                  </td>
                  <td>
                    <button @click="eliminar(task.id)" class="btn btn-danger">
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
      task: {
        task: "",
        description: "",
        date: "",
        expiration_date: "",
        finished: "",
        search: "14",
      },
      id: 0,
      update: true,
      modal: 0,
      titleModal: " ",
      tasks: [],
      search:'1',
    }
  },

  methods: {
    async list() {
      const res = await axios.get("tasks");
      this.tasks = res.data;
    },
      async buscar() {
      const res = await axios.get("tasks");
      this.tasks = res.data;
    },
 
    async eliminar(id) {
      const res = await axios.delete("tasks/" + id);
      this.list();
    },

    async save() {
      if (this.update) {
        const res = await axios.put("tasks/" + this.id, this.task);
      } else {
        const res = await axios.post("tasks", this.task);
      }
      this.closeModal();
      this.list();
    },

    openModal(data = {}) {
      this.modal = 1;

      if (this.update) {
        this.modal = data.id;
        this.titleModal = "Editar Tarea";
        this.id = data.id;

        this.task.task = data.task;
        this.task.description = data.description;
        this.task.expiration_date = data.expiration_date;
        this.task.finished = data.finished;
      } else {
        this.id = 0;
        this.modal = 1;
        this.titleModal = "Crear Tarea";
        this.task.task = "";
        this.task.description = "";
        this.task.expiration_date = "";
        this.task.finished = "";
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

