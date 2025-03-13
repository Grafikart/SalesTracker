import { useOrder } from "../hooks/useOrder.ts";
import { OrderDetail } from "../components/OrderDetail.tsx";
import { ProductIcon } from "../components/ProductIcon.tsx";
import NumberFlow from "@number-flow/react";
import { useRef } from "react";
import { animate } from "motion";
import { randomBetween } from "../functions/number.ts";
import { AnimatePresence, motion } from "motion/react";
import type { ProductItem } from "../api.ts";

export function HomePage() {
    const { items, addProduct, removeProduct, loading, save } = useOrder();
    const total =
        items.reduce(
            (acc, item) => item.quantity * item.product.price + acc,
            0,
        ) / 100;
    return (
        <main>
            <OrderDetail items={items} onRemove={removeProduct} total={total} />
            {Object.keys(window.categories).map((category) => (
                <div key={category} className="mx-4 my-6 space-y-2">
                    <h2 className="text-2xl font-bold">{category}</h2>
                    <section
                        className="grid gap-4"
                        style={{
                            gridTemplateColumns:
                                "repeat(auto-fill,minmax(170px,1fr))",
                        }}
                    >
                        {window.categories[category].map((product) => (
                            <ProductCard
                                product={product}
                                key={product.id}
                                onClick={addProduct}
                            />
                        ))}
                    </section>
                </div>
            ))}
            <AnimatePresence>
                {items.length > 0 && (
                    <motion.button
                        onClick={save}
                        disabled={loading}
                        className="fixed bottom-2 left-4 right-4 btn bg-green mx-auto shadow-md font-semibold"
                        initial={{ y: 20, opacity: 0 }}
                        animate={{ y: 0, opacity: 1 }}
                        exit={{ opacity: 0, y: 20 }}
                    >
                        Enregistrer (<NumberFlow value={total} /> €)
                    </motion.button>
                )}
            </AnimatePresence>
        </main>
    );
}

function ProductCard({
    product,
    onClick,
}: {
    product: ProductItem;
    onClick: (p: ProductItem) => void;
}) {
    const title = product.name
        .replace("(", '<br/><span class="text-xs text-gray">')
        .replace(")", "</span>");

    const button = useRef<HTMLButtonElement>(null);
    const handleClick = () => {
        const div = document.createElement("div");
        div.innerText = "+1";
        div.setAttribute(
            "class",
            "text-green absolute text-4xl font-bold translate-y-5",
        );
        button.current?.appendChild(div);
        const x = randomBetween(-10, 10);
        animate(
            div,
            { y: -20, opacity: 0, x: x, rotate: x * 4 },
            { duration: 0.6 },
        );
        setTimeout(() => {
            div.remove();
        }, 600);
        onClick(product);
    };

    return (
        <button
            ref={button}
            onClick={handleClick}
            className="disabled:opacity-30 py-6 px-4 cursor-pointer card flex flex-col items-center justify-between gap-4"
        >
            <h2
                className="text-xl font-semibold leading-none"
                dangerouslySetInnerHTML={{ __html: title }}
            />
            <ProductIcon
                icon={product.icon}
                className="size-16 flex-none block"
            />
            <div className="self-end text-orange font-semibold">
                <span className="text-3xl leading-none">
                    {product.price / 100}
                </span>{" "}
                €
            </div>
        </button>
    );
}
