import Register from '../pages/Register';
import Login from '../pages/Login';
import CreateEmployee from '../pages/CreateEmployee';
import EmployeeList from '../pages/EmployeeList';
import SearchEmployee from '../pages/SearchEmployee';



const  routes = [
  
    {
        path: "/",
        name: "userlogin",
        meta: {
            layout: "default-layout",
            guest : true,
            
        },
        component: Login,

    },

    {
        path: "/user/register",
        name: "userregister",
        meta: {
            layout: "default-layout",
            guest : true,
            
        },
        component: Register,

    },

    {
        path: "/create-employee",
        name: "createmployee",
        meta: {
            layout: "default-layout",
            requiresAuth : true,
            
        },
        component: CreateEmployee,

    },

    {
        path: "/employee-list",
        name: "employeelist",
        meta: {
            layout: "default-layout",
            requiresAuth : true,
            
        },
        component: EmployeeList,

    },

    {
        path: "/search-employee",
        name: "searchemployee",
        meta: {
            layout: "default-layout",
            requiresAuth : true,
            
        },
        component: SearchEmployee,

    },
];


export default routes;