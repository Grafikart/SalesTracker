import { getApiOrders } from "../api.ts";
import { useEffect } from "react";
import { pushAlert } from "../components/Alerts.tsx";
import { Spinner } from "../components/Spinner.tsx";
import { useInfiniteQuery } from "@tanstack/react-query";
import { InView } from "react-intersection-observer";
import { RiDownloadCloudLine } from "@remixicon/react";
import { OrderRow } from "../components/OrderRow.tsx";

export function OrdersPage() {
    const { data, error, isLoading, fetchNextPage, hasNextPage } =
        useInfiniteQuery({
            queryKey: ["orders"],
            queryFn: ({ pageParam, signal }) => {
                return getApiOrders({ page: pageParam }, { signal });
            },
            getNextPageParam: (page, pages) => {
                if (!page.links?.next) {
                    return undefined;
                }
                return pages.length + 1;
            },
            initialPageParam: 1,
        });

    const orders = data?.pages.flatMap((p) => p.data!);

    useEffect(() => {
        if (!error) {
            return;
        }
        pushAlert({
            message: `Impossible de récupérer les commandes ${error}`,
            type: "error",
        });
    }, [error]);

    const onViewChange = (inView: boolean) => {
        if (inView && hasNextPage) {
            fetchNextPage();
        }
    };

    return (
        <main className="pb-16 bg-white">
            <a
                target="_blank"
                href="/api/download"
                className="p-4 flex justify-center w-full gap-2 text-lg items-center border-b-4 border-b-dark bg-blue"
            >
                Télécharger l'activité
                <RiDownloadCloudLine className="size-6" />
            </a>
            {isLoading && (
                <Spinner
                    className={
                        "fixed top-4 right-1/2 translate-x-1/2 starting:opacity-0"
                    }
                />
            )}
            <section className="divide-y-2 text-gray border-b-2 border-b-dark">
                {orders?.map((order, k) => <OrderRow key={k} order={order} />)}
            </section>
            {hasNextPage && <InView as="div" onChange={onViewChange}></InView>}
        </main>
    );
}
