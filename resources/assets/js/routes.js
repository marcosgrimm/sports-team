import Home from "./components/Home";
import Login from "./components/auth/Login";

import TeamsDefault from "./components/teams/TeamsDefault";
import TeamsList from "./components/teams/TeamsList";
import NewTeam from "./components/teams/NewTeam";
import Team from "./components/teams/Team";

import PlayersDefault from "./components/players/PlayersDefault";
import PlayersList from "./components/players/PlayersList";
import NewPlayer from "./components/players/NewPlayer";
import Player from "./components/players/Player";

export const routes = [
    {
        path: '/',
        component: Home,
        meta: {
            mustAuth: true
        }

    },
    {
        path: '/login',
        component: Login
    },
    {
        path: '/teams',
        component: TeamsDefault,
        meta: {
            mustAuth: true
        },
        children: [
            {
                path:'/',
                component:TeamsList
            },
            {
                path:'new',
                component:NewTeam
            },
            {
                path:':id',
                component:Team
            },
        ]
    },
    {
        path: '/players',
        component: PlayersDefault,
        meta: {
            mustAuth: true
        },
        children: [
            {
                path:'/',
                component:PlayersList
            },
            {
                path:'new',
                component:NewPlayer
            },
            {
                path:':id',
                component:Player
            },

        ]

    }
];