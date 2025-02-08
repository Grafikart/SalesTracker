import { Order, useDeleteApiOrdersOrder } from "../api";
import { clsx } from "clsx";
import { hourFormat, priceFormat } from "../functions/formatters.ts";
import { RiArrowGoBackLine, RiDeleteBinLine } from "@remixicon/react";
import { Spinner } from "./Spinner.tsx";
import { pushAlert } from "./Alerts.tsx";
import { useState } from "react";

export function OrderRow({ order }: { order: Order }) {
    const productName = (name: string) => {
        return name
            .replace("(", '<span class="text-xs text-gray">(')
            .replace(")", ")</span>");
    };
    const { mutateAsync, isPending } = useDeleteApiOrdersOrder();
    const [trashed, setTrashed] = useState(order.trashed);
    const trash = () => {
        mutateAsync({ order: order.id })
            .then(() => {
                setTrashed((v) => !v);
            })
            .catch(() => {
                pushAlert({
                    message: `Impossible d'effectuer cette action`,
                    type: "error",
                });
            });
    };
    return (
        <div
            className={clsx([
                "grid gap-3 p-4 grid-cols-[1fr_90px_100px_40px_40px] text-dark items-center",
                trashed && "line-through *:opacity-40",
            ])}
        >
            {isPending && (
                <Spinner
                    className={
                        "fixed top-4 right-1/2 translate-x-1/2 starting:opacity-0"
                    }
                />
            )}
            <div
                className="font-bold text-dark"
                dangerouslySetInnerHTML={{
                    __html: order.products
                        .map((p) => productName(p.name))
                        .join(", "),
                }}
            ></div>
            <div className="font-bold text-right text-red">
                {priceFormat(order.price / 100)}
            </div>
            <div className="text-gray text-right whitespace-nowrap overflow-hidden text-ellipsis">
                {order.user}
            </div>
            <div>{hourFormat(order.date)}</div>
            <button
                onClick={trash}
                disabled={order.trashable || isPending}
                className="cursor-pointer flex self-stretch items-center border-l-1 border-l-dark justify-center -my-4 -mr-4 disabled:opacity-30"
            >
                {trashed ? <RiArrowGoBackLine /> : <RiDeleteBinLine />}
            </button>
        </div>
    );
}
