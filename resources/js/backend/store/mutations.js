export default {
  SET_COUNTER: (state, { type, counter }) => {
    state.counters[type] = counter
  },
  ADD_SECTION: (state, name) => {
    state.quotes.section[name] = name
  }
}
