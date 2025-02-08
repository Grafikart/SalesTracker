import type { OrderItem } from "../hooks/useOrder.ts";
import { clsx } from "clsx";
import { ProductIcon } from "./ProductIcon.tsx";
import NumberFlow from "@number-flow/react";
import { AnimatePresence, motion } from "motion/react";
import { ProductItem } from "../api.ts";

const animationProps = {
    initial: { x: 12, opacity: 0 },
    animate: { x: 0, opacity: 1 },
    exit: { opacity: 0, x: 12 },
};

export function OrderDetail({
    items,
    onRemove,
    total,
}: {
    total: number;
    items: OrderItem[];
    onRemove: (p: ProductItem) => void;
}) {
    const cls = "bg-blue border-b-3 border-b-dark flex justify-between";

    if (items.length === 0) {
        return (
            <div className={clsx(cls, "p-2")}>
                Sélectionner un ou plusieurs éléments pour créer une commande
            </div>
        );
    }

    return (
        <div className={cls}>
            <div className="flex gap-2 py-2 px-3 flex-wrap">
                <AnimatePresence>
                    {items.map((item, k) => (
                        <motion.button
                            title={item.product.name}
                            onClick={() => onRemove(item.product)}
                            key={item.product.id}
                            className="flex items-center gap-1"
                            {...animationProps}
                        >
                            {k > 0 && "+"}
                            <ProductIcon
                                icon={item.product.icon}
                                className="size-6 flex-none block"
                            />
                            {item.product.name.includes("(") && (
                                <span className="text-gray text-xs">
                                    {item.product.name
                                        .split("(")[1]
                                        .slice(0, -1)}
                                </span>
                            )}
                            <AnimatePresence>
                                {item.quantity > 1 && (
                                    <motion.div
                                        {...animationProps}
                                        className="self-end text-white font-semibold"
                                    >
                                        <span className="leading-none">
                                            x{" "}
                                            <NumberFlow value={item.quantity} />
                                        </span>
                                    </motion.div>
                                )}
                            </AnimatePresence>
                        </motion.button>
                    ))}
                </AnimatePresence>
            </div>
            <div className="border-l-dark border-l-2 font-semibold px-3 bg-purple text-white flex items-center">
                <span className="text-2xl leading-none">
                    <NumberFlow value={total} />
                </span>
                €
            </div>
        </div>
    );
}
