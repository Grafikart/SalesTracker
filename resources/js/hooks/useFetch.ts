import { useCallback, useEffect, useState } from "react";

export function useFetch<T>(url: string, options: RequestInit = {}) {
    const [loading, setLoading] = useState(true);
    const [data, setData] = useState<T | null>(null);
    const [errors, setErrors] = useState(null);

    useEffect(() => {
        fetch(url, {
            ...options,
            headers: {
                Accept: "application/json; charset=UTF-8",
                ...options.headers,
            },
        })
            .then((r) => r.json())
            .then((data) => {
                setData(data);
            })
            .catch((e) => {
                setErrors(e);
            })
            .finally(() => {
                setLoading(false);
            });
    }, []);

    return {
        loading,
        data,
        errors,
    };
}

export function useFetchMutation<T>(url: string, options: RequestInit = {}) {
    const [loading, setLoading] = useState(false);
    const [errors, setErrors] = useState(null);

    const mutate = useCallback((data: Record<string, unknown>) => {
        setLoading(true);
        return fetch(url, {
            ...options,
            body: JSON.stringify(data),
            headers: {
                "Content-Type": "application/json; charset=UTF-8",
                Accept: "application/json; charset=UTF-8",
                ...options.headers,
            },
        })
            .then((r) => {
                if (r.ok) {
                    return r.json() as Promise<T>;
                }
                return r.json().then((v) => {
                    throw new Error(v.message);
                });
            })
            .catch((e) => {
                setErrors(e);
                throw e;
            })
            .finally(() => {
                setLoading(false);
            });
    }, []);

    return {
        loading,
        mutate,
        errors,
    };
}
