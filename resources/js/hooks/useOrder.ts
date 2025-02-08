import { useCallback, useState } from "react";
import { useFetchMutation } from "./useFetch.ts";
import { pushAlert } from "../components/Alerts.tsx";
import type { ProductItem } from "../api.ts";

export type OrderItem = {
    quantity: number;
    product: ProductItem;
};

export function useOrder() {
    const [items, setItems] = useState<OrderItem[]>([]);
    const { loading, mutate } = useFetchMutation("/api/orders", {
        method: "POST",
    });
    return {
        loading: loading,
        save: () => {
            mutate({
                items: items.map((item) => ({
                    id: item.product.id,
                    quantity: item.quantity,
                })),
            })
                .then(() => {
                    setItems([]);
                    pushAlert({
                        message: "La commande a bien été enregistrée",
                        type: "success",
                    });
                })
                .catch((e) => {
                    pushAlert({
                        message:
                            "Impossible d'enregistrer la commande " +
                            e.toString(),
                        type: "error",
                    });
                });
        },
        removeProduct: useCallback((p: ProductItem) => {
            setItems((items) => {
                const item = items.find((item) => item.product.id === p.id);
                if (item?.quantity === 1) {
                    return items.filter((item) => item.product.id !== p.id);
                }
                return items.map((item) =>
                    item.product.id === p.id
                        ? {
                              ...item,
                              quantity: item.quantity - 1,
                          }
                        : item,
                );
            });
        }, []),
        addProduct: useCallback((p: ProductItem) => {
            setItems((items) => {
                const item = items.find((item) => item.product.id === p.id);
                if (!item) {
                    return [
                        ...items,
                        {
                            quantity: 1,
                            product: p,
                        },
                    ];
                }
                return items.map((item) =>
                    item.product.id === p.id
                        ? {
                              ...item,
                              quantity: item.quantity + 1,
                          }
                        : item,
                );
            });
        }, []),
        items: items,
    };
}
