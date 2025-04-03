import { ApolloClient, InMemoryCache, HttpLink } from "@apollo/client";

const client = new ApolloClient({
  link: new HttpLink({
    uri: "http://localhost:8000/graphql",
    credentials: "include", // Match backend's Access-Control-Allow-Credentials: true
  }),
  cache: new InMemoryCache(),
});

export default client;
