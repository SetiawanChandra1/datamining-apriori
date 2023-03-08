import Authenticated from "@/Layouts/Authenticated/Index";
import InputLabel from "@/Components/InputLabel";
import TextInput from "@/Components/TextInput";
import InputError from "@/Components/InputError";
import PrimaryButton from "@/Components/PrimaryButton";
import FlashMessage from "@/Components/FlashMessage";
import { Head, useForm } from "@inertiajs/inertia-react";
import React, { useState } from "react";

export default function Index({
    auth,
    flashMessage,
    passMinimumSupport,
    failMinimumSupport,
    variantFrequency,
    totalTransactions,
}) {
    const { setData, post, processing, errors } = useForm();

    const onHandleChange = (event) => {
        setData(
            event.target.name,
            event.target.type === "file"
                ? event.target.files[0]
                : event.target.value
        );
    };

    const submit = (e) => {
        e.preventDefault();

        post(route("user.dashboard.dataprocess.store"));
    };

    return (
        <Authenticated auth={auth}>
            <Head title="Transactions" />
            {flashMessage?.message && (
                <FlashMessage message={flashMessage.message} />
            )}
            <form onSubmit={submit}>
                <div className="flex items-center">
                    <div className="mt-3">
                        <InputLabel forInput="startDate" value="Start Date:" />
                        <TextInput
                            type="date"
                            name="start_date"
                            variant="primary-outline"
                            handleChange={onHandleChange}
                            isError={errors.start_date}
                            className="w-52"
                        />
                        <InputError
                            message={errors.start_date}
                            className="mt-2"
                        />
                    </div>
                    <div className="ml-60">
                        <InputLabel
                            forInput="minimumSupport"
                            value="Minimum Support Value :"
                        />
                        <TextInput
                            type="text"
                            name="minimum_support"
                            defaultValue=""
                            variant="primary-outline"
                            handleChange={onHandleChange}
                            placeholder="Enter the value of minimum support"
                            isError={errors.minimum_support}
                            className="w-96"
                        />
                        <InputError
                            message={errors.minimum_support}
                            className="mt-2"
                        />
                    </div>
                </div>
                <div className="flex items-center">
                    <div className="mt-3">
                        <InputLabel forInput="endDate" value="End Date:" />
                        <TextInput
                            type="date"
                            name="end_date"
                            variant="primary-outline"
                            handleChange={onHandleChange}
                            isError={errors.end_date}
                            className="w-52"
                        />
                        <InputError
                            message={errors.end_date}
                            className="mt-2"
                        />
                    </div>
                    <div className="mt-3 ml-60">
                        <InputLabel
                            forInput="minimumConfidence"
                            value="Minimum Confidence Value :"
                        />
                        <TextInput
                            type="text"
                            name="minimum_confidence"
                            defaultValue=""
                            variant="primary-outline"
                            handleChange={onHandleChange}
                            placeholder="Enter the value of minimum confidence"
                            isError={errors.minimum_confidence}
                            className="w-96"
                        />
                        <InputError
                            message={errors.minimum_confidence}
                            className="mt-2"
                        />
                    </div>
                </div>
                <PrimaryButton
                    type="submit"
                    className="mt-8 w-2/12"
                    variant="primary"
                    processing={processing}
                >
                    Process Data
                </PrimaryButton>
            </form>
            <h1 className="mt-8 mb-2">
                <b>Total Transactions : {totalTransactions}</b>
            </h1>
            <h1 className="mt-8 mb-2">
                <b>Table Itemset 1</b>
            </h1>
            <table className="table-auto">
                <thead>
                    <tr>
                        <th className="px-4 py-2">No</th>
                        <th className="px-4 py-2">Item</th>
                        <th className="px-4 py-2">Amount</th>
                        <th className="px-4 py-2">Support</th>
                        <th className="px-4 py-2">Status</th>
                    </tr>
                </thead>
                <tbody>
                    {passMinimumSupport &&
                        variantFrequency &&
                        Object.entries(passMinimumSupport).map(
                            ([key, support], index) => (
                                <tr key={key}>
                                    <td className="border px-4 py-2">
                                        {index + 1}
                                    </td>
                                    <td className="border px-4 py-2">{key}</td>
                                    <td className="border px-4 py-2">
                                        {variantFrequency[key]}
                                    </td>
                                    <td className="border px-4 py-2">
                                        {support}%
                                    </td>
                                    <td className="border px-4 py-2 text-green-500">
                                        <b>Pass</b>
                                    </td>
                                </tr>
                            )
                        )}
                </tbody>
            </table>
            {failMinimumSupport &&
                variantFrequency &&
                Object.entries(failMinimumSupport).length > 0 && (
                    <table className="table-auto mt-4">
                        <thead>
                            <tr>
                                <th className="px-4 py-2">No</th>
                                <th className="px-4 py-2">Item</th>
                                <th className="px-4 py-2">Amount</th>
                                <th className="px-4 py-2">Support</th>
                                <th className="px-4 py-2">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            {Object.entries(failMinimumSupport).map(
                                ([key, support], index) => (
                                    <tr key={key}>
                                        <td className="border px-4 py-2">
                                            {index + 1}
                                        </td>
                                        <td className="border px-4 py-2">
                                            {key}
                                        </td>
                                        <td className="border px-4 py-2">
                                            {variantFrequency[key]}
                                        </td>
                                        <td className="border px-4 py-2">
                                            {support}%
                                        </td>
                                        <td className="border px-4 py-2 text-red-500">
                                            <b>Fail</b>
                                        </td>
                                    </tr>
                                )
                            )}
                        </tbody>
                    </table>
                )}
        </Authenticated>
    );
}
