const express = require('express');
const { createHandler } = require('graphql-http/lib/use/express');
const mongoose = require('mongoose');
const typeDefs = require('./schema/typedef')
const queryResolvers = require("./schema/resolvers/query");
const mutationResolvers = require("./schema/resolvers/mutation");
const { makeExecutableSchema } =require('@graphql-tools/schema')

mongoose.connect('mongodb://localhost:27017/BE_Lab5');

const app = express();

const resolvers = {
    ...queryResolvers,
    ...mutationResolvers,
};

schema = makeExecutableSchema({ typeDefs, resolvers })

app.all('/graphql', createHandler(
    { schema: schema}));

app.listen(3000,()=>{
    console.log("Server is running")
})