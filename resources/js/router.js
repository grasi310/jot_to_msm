import Vue from 'vue';
import VueRouter from "vue-router";
import ExampleComponent from "./components/ExampleComponent";
import ContactsCreate from "./views/ContactsCreate";
import ContactsShow from "./views/ContactsShow";
import ContactsEdit from "./views/ContactsEdit";
import ContactsIndex from "./views/ContactsIndex";
import BirthdaysIndex from "./views/BirthdaysIndex";
import Logout from "./Actions/Logout";
import ProjectsCreate from "./views/ProjectsCreate";
import ProjectsShow from "./views/ProjectsShow";
import ProjectsEdit from "./views/ProjectsEdit";
import ProjectsIndex from "./views/ProjectsIndex";

Vue.use(VueRouter);

export default new VueRouter({
    routes: [
        {
            path: '/', component: ExampleComponent,
            meta: {title: 'Welcome'}
        },
        {
            path: '/contacts/create', component: ContactsCreate,
            meta: {title: 'New Contact'}
        },
        {
            path: '/contacts/:id', component: ContactsShow,
            meta: {title: 'Details for Contact'}
        },
        {
            path: '/contacts/:id/edit', component: ContactsEdit,
            meta: {title: 'Edit Contact'}
        },
        {
            path: '/contacts', component: ContactsIndex,
            meta: {title: 'Contacts'}
        },

        {
            path: '/birthdays', component: BirthdaysIndex,
            meta: {title: 'This Month´s Birthdays'}
        },

        {
            path: '/projects/create', component: ProjectsCreate,
            meta: {title: 'New Project'}
        },
        {
            path: '/projects/:id', component: ProjectsShow,
            meta: {title: 'Details for Project'}
        },
        {
            path: '/projects/:id/edit', component: ProjectsEdit,
            meta: {title: 'Edit Project'}
        },
        {
            path: '/projects', component: ProjectsIndex,
            meta: {title: 'Projects'}
        },

        {
            path: '/logout', component: Logout,
        },
    ],
    mode: 'history'
});
