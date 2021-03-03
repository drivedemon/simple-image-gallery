import Vue from 'vue'
import VueRouter from 'vue-router'
import LoginComponent from "@/views/Login";
import UploadComponent from "@/views/FileUpload";
import DashboardComponent from "@/views/Dashboard";

Vue.use(VueRouter)

const routes = [
    {
        path: '/',
        redirect: {
            name: "login"
        }
    },
    {
        path: "/login",
        name: "login",
        component: LoginComponent
    },
    {
        path: "/dashboard",
        name: "dashboard",
        component: DashboardComponent
    },
    {
        path: "/upload",
        name: "upload",
        component: UploadComponent
    }
]

const router = new VueRouter({
    mode: 'history',
    base: process.env.BASE_URL,
    routes,
})

export default router