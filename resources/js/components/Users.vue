<template>
  <div>
    <form @submit.prevent="addUser" class="mb-3">
      <div class="form-row">
        <div class="col">
          <input type="text" class="form-control" placeholder="Name" v-model="user.name">
        </div>
        <div class="col">
          <input type="text" class="form-control" placeholder="Email" v-model="user.email">
        </div>
        <div class="col">
          <input type="text" class="form-control" placeholder="Address" v-model="user.address">
        </div>
        <div class="col">
          <input type="text" class="form-control" placeholder="Postcode" v-model="user.postcode">
        </div>
        <div class="col">
          <input type="text" class="form-control" placeholder="Phone" v-model="user.phone">
        </div>
        <div class="col">
          <button class="btn btn-primary" type="submit">Save</button>
        </div>
      </div>
    </form>
    <nav aria-label="Page navigation">
      <ul class="pagination">
        <li v-bind:class="[{disabled: !pagination.prev_page_url}]" class="page-item"><a class="page-link" href="#" @click="fetchUsers(pagination.prev_page_url)">Previous</a></li>

        <li class="page-item disabled"><a class="page-link text-dark" href="#">Page {{ pagination.current_page }} of {{ pagination.last_page }}</a></li>

        <li v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item"><a class="page-link" href="#" @click="fetchUsers(pagination.next_page_url)">Next</a></li>
      </ul>
    </nav>
    <table class="table">
      <thead class="thead-dark">
        <tr>
          <th scope="col">#</th>
          <th scope="col">Name</th>
          <th scope="col">Email</th>
          <th scope="col">Address</th>
          <th scope="col">Postcode</th>
          <th scope="col">Phone number</th>
          <th scope="col">Action</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="user in users" v-bind:key="user.id">
          <th scope="row">{{ user.id }}</th>
          <td>{{ user.name }}</td>
          <td>{{ user.email }}</td>
          <td>{{ user.address }}</td>
          <td>{{ user.postcode }}</td>
          <td>{{ user.phone }}</td>
          <td>
            <button type="button" class="btn btn-danger" @click="deleteUser(user.id)">Delete</button>
            <button type="button" class="btn btn-warning" @click="editUser(user)">Edit</button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
  export default {
    data() {
      return {
        users: [],
        user: {
          id: '',
          name: '',
          email: '',
          address: '',
          postcode: '',
          phone: ''
        },
        pagination: {},
        edit: false
      }
    },

    created() {
      this.fetchUsers();
    },

    methods: {
      fetchUsers(page_url) {
        let vm = this;
        page_url = page_url || 'api/users'
        fetch(page_url)
          .then(res => res.json())
          .then(res => {
            this.users = res.data;
            vm.makePagination(res.meta, res.links);
          })
          .catch(err => console.log(err));
      },
      makePagination(meta, links) {
        let pagination = {
          current_page: meta.current_page,
          last_page: meta.last_page,
          next_page_url: links.next,
          prev_page_url: links.prev
        }

        this.pagination = pagination;
      },
      deleteUser(id) {
        if (confirm('Are you sure?')) {
          fetch(`api/users/${id}`, {
            method: 'delete'
          })
            .then(res => res.json())
            .then(data => {
              alert('Article removed');
              this.fetchUsers();
            })
            .catch(err => console.log(err));
        }
      },
      addUser() {
        if (this.edit === false) {
          //add
          fetch('api/users', {
            method: 'post',
            body: JSON.stringify(this.user),
            headers: {
              'content-type': 'application/json'
            }
          })
            .then(res => res.json())
            .then(data => {
              this.user.name = '';
              this.user.email = '';
              this.user.address = '';
              this.user.postcode = '';
              this.user.phone = '';
              alert('Added a new user');
              this.fetchUsers();
            })
            .catch(err => console.log(err));
        } else {
          //update
          fetch(`api/users/${this.user.id}`, {
            method: 'put',
            body: JSON.stringify(this.user),
            headers: {
              'content-type': 'application/json'
            }
          })
            .then(res => res.json())
            .then(data => {
              this.user.name = '';
              this.user.email = '';
              this.user.address = '';
              this.user.postcode = '';
              this.user.phone = '';
              alert('User updated');
              this.fetchUsers();
            })
            .catch(err => console.log(err));
        }
      },
      editUser(user) {
        this.edit = true;
        this.user.id = user.id;
        this.user.name = user.name;
        this.user.email = user.email;
        this.user.address = user.address;
        this.user.postcode = user.postcode;
        this.user.phone = user.phone;
      }
    }
  }
</script>
