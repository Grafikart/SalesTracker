import { useState } from "react";
import { clsx } from "clsx";
import { AnimatePresence, motion } from "motion/react";

type Alert = {
    message: string;
    type: "success" | "error";
};

const alertRef = { current: (_: Alert) => {} };

export function pushAlert(a: Alert) {
    alertRef.current(a);
}

export function Alerts() {
    const [items, setItems] = useState<Alert[]>([]);
    alertRef.current = (a: Alert) => {
        setItems((items) => [...items, a]);
        setTimeout(() => {
            setItems((items) => items.filter((v) => v !== a));
        }, 3000);
    };
    return (
        <aside className="fixed left-0 right-0 bottom-0 flex flex-col z-10">
            <AnimatePresence>
                {items.map((item) => (
                    <motion.div
                        initial={{ y: 20, opacity: 0 }}
                        animate={{ y: 0, opacity: 1 }}
                        exit={{ opacity: 0, y: 20 }}
                        key={item.message}
                        className={clsx(
                            "p-4 flex justify-between items-center gap-4 text-lg border-t-2 border-t-dark",
                            item.type === "success" && "bg-green",
                            item.type === "error" && "bg-red",
                        )}
                    >
                        <p>{item.message}</p>
                    </motion.div>
                ))}
            </AnimatePresence>
        </aside>
    );
}
