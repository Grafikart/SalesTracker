import { Link, Outlet } from "react-router";
import { Alerts } from "./Alerts.tsx";
import { RiMenu3Line, RiStore2Line } from "@remixicon/react";

export function App() {
    return (
        <>
            <header className="text-orange-900 text-xl font-semibold text-center shadow-sm bg-orange flex justify-between items-center sticky top-0 left-0 right-0 border-b-3 border-b-dark">
                <Link
                    to="/"
                    className="border-r-2 border-r-dark h-full p-3 hover:bg-white/30 grid place-items-center"
                >
                    <RiStore2Line />
                </Link>
                <div>{window.username}</div>
                <Link
                    to="/orders"
                    className="border-l-2 border-l-dark h-full p-3 hover:bg-white/30 grid place-items-center"
                >
                    <RiMenu3Line />
                </Link>
            </header>
            <Outlet />
            <Alerts />
        </>
    );
}
